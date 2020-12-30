<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Loot;
use App\Entity\Player;
use App\Entity\Roster;
use App\Entity\Week;
use App\Repository\InstanceRepository;
use App\Repository\ItemRepository;
use App\Repository\LootRepository;
use App\Repository\PlayerJobRepository;
use App\Repository\WeekRepository;
use App\Repository\WishItemRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/loot")
 */
class LootController extends AbstractController
{

    /**
     * @Route("/", name="loot_patch", methods={"PATCH"})
     */
    public function patchLootItem(Request $request,
                                  SerializerInterface $serializer,
                                  InstanceRepository $instanceRepository,
                                  PlayerJobRepository $playerJobRepository,
                                  ItemRepository $itemRepository,
                                  EntityManagerInterface $em,
                                  WeekRepository $weekRepository,
                                  LootRepository $lootRepository)
    {
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $loot = $json['id'] == NULL ? NULL : $lootRepository->findOneBy(['id' => $json['id']]);
        $itemChest = $itemRepository->findOneBy(['id' => $json['item_id']]);
        $instance = $instanceRepository->findOneBy(['value' => $json['instance']]);
        $playerJob = $playerJobRepository->findOneBy(['id' => $json['playerjob_id']]);
        $newCurrentStuff = $playerJob->getCurrentstuff();
        $newOldStuff = $playerJob->getOldStuff();
        $currentWeek = date('W');
        $dateCheck = date('D') === 'Mon';
        $job = $playerJob->getJob();
        $slotChest = $itemChest->getSlot();
        $items = $job->getItems();
        $itemToAssignCurrent ='';
        foreach ($items as $item){
            if($item->getSlot() === $slotChest && $item->getIlvl() == 530 && $item->getIsSavage()){
                $itemToAssignCurrent = $item;
            }
        }
        if ($dateCheck) {
            $currentWeek -= 1;
        }
        if (!$weekRepository->findOneBy(['value'=> $currentWeek])){
            $newWeek = new Week();
            $newWeek->setValue($currentWeek === 53 ? 1 : $currentWeek);
            $newWeek->setYear(date("Y"));
            $em->persist($newWeek);
            $em->flush();
        }
        if ($loot) {
            $oldStuff = $loot->getPlayerJob()->getOldStuff();
            $currentStuff = $loot->getPlayerJob()->getCurrentstuff();
            $oldSlotId = $loot->getItem()->getSlot()->getId();
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItemUpgraded(NULL);
            $loot->setItem($itemChest);
            $loot->setWeek($weekRepository->findOneBy(['value'=> $currentWeek]));
            $this->deleteOldItem($oldSlotId, $oldStuff, $currentStuff, $em);
            $this->setItemIntoCurrentstuff($slotChest->getId(),$newCurrentStuff, $newOldStuff,$itemToAssignCurrent? $itemToAssignCurrent: $item, $em);

        } else {
            $loot = new Loot();
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($itemChest);
            $loot->setItemUpgraded(NULL);
            $loot->setWeek($weekRepository->findOneBy(['value'=> $currentWeek]));
            $this->setItemIntoCurrentstuff($slotChest->getId(), $newCurrentStuff, $newOldStuff,$itemToAssignCurrent? $itemToAssignCurrent: $item, $em);
        }
        $em->persist($loot);
        $em->flush();
        return $this->json($loot, 200, [], ['groups' => 'loots']);
    }

    /**
     * @Route("/week", name="loot_get", methods={"GET"})
     */
    public function getLootbyWeek(LootRepository $lootRepository, EntityManagerInterface $em){
        $week = isset($_GET['week'])? $_GET['week'] : '';
        $roster = $this->getUser();
        $conn = $em->getConnection();
        $sql = '
SELECT item.name AS item_name,
item.is_upgrade as item_isUpgrade,
loot.item_upgraded_id AS item_upgraded,
item.id AS item_id,
instance.id AS instance_id, 
player.name AS player_name,
loot.id AS loot_id,
loot.chest,
player_job.id AS playerjob_id,
item.img_url AS item_url, 
week.value AS week,
instance.img_url AS instance_url,
instance.value as instance_value,
player.img_url AS player_url,
image.imgpath AS job_img  FROM week 
INNER JOIN `loot` ON week.id = loot.week_id
INNER JOIN player_job ON player_job.id = loot.playerjob_id
INNER JOIN item ON item.id = loot.item_id
INNER JOIN player ON player.id = player_job.player_id
INNER JOIN instance ON instance.id = loot.instance_id
INNER JOIN job ON player_job.job_id = job.id
INNER JOIN image ON job.image_id = image.id
WHERE week.value = :week AND loot.roster_id = :roster';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['week' => $week, 'roster' => $roster->getId()]);
        $result  =  $stmt->fetchAll();
        return $this->json($result, 200, []);
    }

    public function deleteOldItem($slotId, $oldStuff, $currentStuff, $em){
        switch ($slotId) {
            case 1 :
                $currentStuff->setMainHand($oldStuff->getMainHand()? $oldStuff->getMainHand() : null);
                break;
            case 2 :

                break;
            case 3 :
                $currentStuff->setHead($oldStuff->getHead()? $oldStuff->getHead() : null);
                break;
            case 4 :
                $currentStuff->setBody($oldStuff->getBody()? $oldStuff->getBody() : null);
                break;
            case 5 :
                $currentStuff->setHands($oldStuff->getHands()? $oldStuff->getHands() : null);
                break;
            case 6 :
                $currentStuff->setBelt($oldStuff->getBelt()? $oldStuff->getBelt() : null);
                break;
            case 7 :
                $currentStuff->setLegs($oldStuff->getLegs()? $oldStuff->getLegs() : null);
                break;
            case 8 :
                $currentStuff->setFeet($oldStuff->getFeet()? $oldStuff->getFeet() : null);
                break;
            case 9 :
                $currentStuff->setEarring($oldStuff->getEarring()? $oldStuff->getEarring() : null);
                break;
            case 10 :
                $currentStuff->setNeck($oldStuff->getNeck()? $oldStuff->getNeck() : null);
                break;
            case 11 :
                $currentStuff->setBracelet($oldStuff->getBracelet()? $oldStuff->getBracelet() : null);
                break;
            case 12 :
                $currentStuff->setRing1($oldStuff->getRing1()? $oldStuff->getRing1() : null);
                break;
        }
        $em->persist($currentStuff);
        $em->flush();
    }
    public function setItemIntoCurrentstuff($slotId ,$newCurrentStuff, $newOldStuff ,$itemToAssignCurrent, $em)
    {
        switch ($slotId) {
            case 1 :
                $newOldStuff->setMainHand($newCurrentStuff->getMainHand()? $newCurrentStuff->getMainHand() : null);
                $newCurrentStuff->setMainHand($itemToAssignCurrent);
                break;
            case 2 :
                $newOldStuff->setOffHand($newCurrentStuff->getOffHand()? $newCurrentStuff->getOffHand() : null);
                $newCurrentStuff->setOffHand($itemToAssignCurrent);
                break;
            case 3 :
                $newOldStuff->setHead($newCurrentStuff->getHead()? $newCurrentStuff->getHead() : null);
                $newCurrentStuff->setHead($itemToAssignCurrent);
                break;
            case 4 :
                $newOldStuff->setBody($newCurrentStuff->getBody()? $newCurrentStuff->getBody() : null);
                $newCurrentStuff->setBody($itemToAssignCurrent);
                break;
            case 5 :
                $newOldStuff->setHands($newCurrentStuff->getHands()? $newCurrentStuff->getHands() : null);
                $newCurrentStuff->setHands($itemToAssignCurrent);
                break;
            case 6 :
                $newOldStuff->setBelt($newCurrentStuff->getBelt()? $newCurrentStuff->getBelt() : null);
                $newCurrentStuff->setBelt($itemToAssignCurrent);
                break;
            case 7 :
                $newOldStuff->setLegs($newCurrentStuff->getLegs()? $newCurrentStuff->getLegs() : null);
                $newCurrentStuff->setLegs($itemToAssignCurrent);
                break;
            case 8 :
                $newOldStuff->setFeet($newCurrentStuff->getFeet()? $newCurrentStuff->getFeet() : null);
                $newCurrentStuff->setFeet($itemToAssignCurrent);
                break;
            case 9 :
                $newOldStuff->setEarring($newCurrentStuff->getEarring()? $newCurrentStuff->getEarring() : null);
                $newCurrentStuff->setEarring($itemToAssignCurrent);
                break;
            case 10 :
                $newOldStuff->setNeck($newCurrentStuff->getNeck()? $newCurrentStuff->getNeck() : null);
                $newCurrentStuff->setNeck($itemToAssignCurrent);
                break;
            case 11 :
                $newOldStuff->setBracelet($newCurrentStuff->getBracelet()? $newCurrentStuff->getBracelet() : null);
                $newCurrentStuff->setBracelet($itemToAssignCurrent);
                break;
            case 12 :
                if($itemToAssignCurrent->getIsSavage()) {
                    $newOldStuff->setRing1($newCurrentStuff->getRing1() ? $newCurrentStuff->getRing1() : null);
                    $newCurrentStuff->setRing1($itemToAssignCurrent);
                }
                if(!$itemToAssignCurrent->getIsSavage()) {
                    $newOldStuff->setRing2($newCurrentStuff->getRing2() ? $newCurrentStuff->getRing2() : null);
                    $newCurrentStuff->setRing2($itemToAssignCurrent);
                }
                break;
        }
        $em->persist($newCurrentStuff, $newOldStuff);

    }
    /**
     * @Route("/setupgrade", name="loot_setpatch", methods={"PATCH"})
     */
    public function getUpgrade(Request $request,
                               SerializerInterface $serializer,
                               InstanceRepository $instanceRepository,
                               PlayerJobRepository $playerJobRepository,
                               ItemRepository $itemRepository,
                               EntityManagerInterface $em,
                               LootRepository $lootRepository,WeekRepository  $weekRepository)
    {
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $instance = $instanceRepository->findOneBy(['value' => $json['instance']]);
        $playerJob = $playerJobRepository->findOneBy(['id' => $json['playerjob_id']]);
        $loot = $json['id'] == NULL ? NULL : $lootRepository->findOneBy(['id' => $json['id']]);
        $item = $itemRepository->findOneBy(['id' => $json['item_id']]);
        $itemToUpgrade = $itemRepository->findOneBy(['id' => $json['itemUpgrade']]);
        $newCurrentStuff = $playerJob->getCurrentstuff();
        $newOldStuff = $playerJob->getOldStuff();
        $currentWeek = date('W');
        $dateCheck = date('D') === 'Mon';
        $slot = $itemToUpgrade->getSlot();
        if ($dateCheck) {
            $currentWeek -= 1;
        }
        if (!$weekRepository->findOneBy(['value'=> $currentWeek])){
            $newWeek = new Week();
            $newWeek->setValue($currentWeek === 53 ? 1 : $currentWeek);
            $newWeek->setYear(date("Y"));
            $em->persist($newWeek);
            $em->flush();
        }
        if ($loot){
            $oldStuff = $loot->getPlayerJob()->getOldStuff();
            $currentStuff = $loot->getPlayerJob()->getCurrentstuff();
            $oldSlotId = $loot->getItemUpgraded()->getSlot()->getId();
            $loot->setInstance($instance);
            $loot->setChest(NULL);
            $loot->setItem($item);
            $loot->setItemUpgraded($itemToUpgrade);
            $loot->setRoster($this->getUser());
            $loot->setPlayerJob($playerJob);
            $loot->setWeek($weekRepository->findOneBy(['value'=> $currentWeek]));
            $this->deleteOldItem($oldSlotId, $oldStuff, $currentStuff, $em);
            $this->setItemIntoCurrentstuff($slot->getId(),$newCurrentStuff, $newOldStuff,$itemToUpgrade, $em);

        }
        if (!$loot){
            $loot = new Loot();
            $loot->setInstance($instance);
            $loot->setChest(NULL);
            $loot->setItem($item);
            $loot->setItemUpgraded($itemToUpgrade);
            $loot->setRoster($this->getUser());
            $loot->setPlayerJob($playerJob);
            $loot->setWeek($weekRepository->findOneBy(['value'=> $currentWeek]));
            $this->setItemIntoCurrentstuff($slot->getId(), $newCurrentStuff, $newOldStuff,  $itemToUpgrade, $em);
        }
        $em->persist($loot);
        $em->flush();
        return $this->json($loot, 200, [], ['groups' => 'loots']);
    }

}
