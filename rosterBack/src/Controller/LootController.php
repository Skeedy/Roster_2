<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Loot;
use App\Entity\Player;
use App\Repository\InstanceRepository;
use App\Repository\ItemRepository;
use App\Repository\LootRepository;
use App\Repository\PlayerJobRepository;
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
    public function patchLootItem(Request $request, SerializerInterface $serializer, InstanceRepository $instanceRepository, PlayerJobRepository $playerJobRepository, ItemRepository $itemRepository, EntityManagerInterface $em, LootRepository $lootRepository)
    {
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $loot = $json['id'] == NULL ? NULL : $lootRepository->findOneBy(['id' => $json['id']]);
        $itemChest = $itemRepository->findOneBy(['id' => $json['item_id']]);
        $instance = $instanceRepository->findOneBy(['value' => $json['instance']]);
        $playerJob = $playerJobRepository->findOneBy(['id' => $json['playerjob_id']]);
        $newCurrentStuff = $playerJob->getCurrentstuff();
        $currentWeek = date('W');
        $dateCheck = date('D') === 'Mon';
        $job = $playerJob->getJob();
        $slot = $itemChest->getSlot();
        $items = $job->getItems();
        $itemToAssignCurrent ='';
        foreach ($items as $item){
            if($item->getSlot() === $slot && $item->getIlvl() == 500 && $item->getIsSavage()){
                $itemToAssignCurrent = $item;
            }
        }
        if ($dateCheck) {
            $currentWeek -= 1;
        }
        if ($loot) {
            $currentStuffToDelete = $loot->getPlayerJob()->getCurrentstuff();
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($itemChest);
            $loot->setWeek($currentWeek);
            $this->setItemIntoCurrentstuff($slot->getId(), $currentStuffToDelete ,$newCurrentStuff, $itemToAssignCurrent? $itemToAssignCurrent: $item, $em);

        } else {
            $loot = new Loot();
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($itemChest);
            $loot->setWeek($currentWeek);
            $this->setItemIntoCurrentstuff($slot->getId(), null ,$newCurrentStuff, $itemToAssignCurrent? $itemToAssignCurrent: $item, $em);
        }
        $em->persist($loot);
        $em->flush();
        return $this->json($loot, 200, [], ['groups' => 'loots']);
    }

    public function setItemIntoCurrentstuff($slotId, $currentStuffToDelete ,$newCurrentStuff, $itemToAssignCurrent, $em)
    {
        switch ($slotId) {
            case 1 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setMainHand($currentStuffToDelete->getPrevMainHand()? $currentStuffToDelete->getPrevMainHand() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getMainHand();
                $newCurrentStuff->setMainHand($itemToAssignCurrent);
                $newCurrentStuff->setPrevMainHand($previousStuff);
                break;
            case 2 :
                $newCurrentStuff->setOffHand($itemToAssignCurrent);
                break;
            case 3 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setHead($currentStuffToDelete->getPrevHead()? $currentStuffToDelete->getPrevHead() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getHead();
                $newCurrentStuff->setHead($itemToAssignCurrent);
                $newCurrentStuff->setPrevHead($previousStuff);
                break;
            case 4 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setBody($currentStuffToDelete->getPrevBody()? $currentStuffToDelete->getPrevBody() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getBody();
                $newCurrentStuff->setBody($itemToAssignCurrent);
                $newCurrentStuff->setPrevBody($previousStuff);
                break;
            case 5 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setHands($currentStuffToDelete->getPrevHands()? $currentStuffToDelete->getPrevHands() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getHands();
                $newCurrentStuff->setHands($itemToAssignCurrent);
                $newCurrentStuff->setPrevHands($previousStuff);
                break;
            case 6 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setBelt($currentStuffToDelete->getPrevBelt()? $currentStuffToDelete->getPrevBelt() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getBelt();
                $newCurrentStuff->setBelt($itemToAssignCurrent);
                $newCurrentStuff->setPrevBelt($previousStuff);
                break;
            case 7 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setLegs($currentStuffToDelete->getPrevLegs()? $currentStuffToDelete->getPrevLegs() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getLegs();
                $newCurrentStuff->setLegs($itemToAssignCurrent);
                $newCurrentStuff->setPrevLegs($previousStuff);
                break;
            case 8 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setFeet($currentStuffToDelete->getPrevFeet()? $currentStuffToDelete->getPrevFeet() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getFeet();
                $newCurrentStuff->setFeet($itemToAssignCurrent);
                $newCurrentStuff->setPrevFeet($previousStuff);
                break;
            case 9 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setEarring($currentStuffToDelete->getPrevEarring()? $currentStuffToDelete->getPrevEarring() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getEarring();
                $newCurrentStuff->setEarring($itemToAssignCurrent);
                $newCurrentStuff->setPrevEarring($previousStuff);
                break;
            case 10 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setNeck($currentStuffToDelete->getPrevNeck()? $currentStuffToDelete->getPrevNeck() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getNeck();
                $newCurrentStuff->setNeck($itemToAssignCurrent);
                $newCurrentStuff->setPrevNeck($previousStuff);
                break;
            case 11 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setBracelet($currentStuffToDelete->getPrevBracelet()? $currentStuffToDelete->getPrevBracelet() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getBracelet();
                $newCurrentStuff->setBracelet($itemToAssignCurrent);
                $newCurrentStuff->setPrevBracelet($previousStuff);
                break;
            case 12 :
                if($currentStuffToDelete !== null) {
                    $currentStuffToDelete->setRing1($currentStuffToDelete->getPrevRing1()? $currentStuffToDelete->getPrevRing1() : null);
                    $em->persist($currentStuffToDelete);
                }
                $previousStuff = $newCurrentStuff->getRing1();
                $newCurrentStuff->setRing1($itemToAssignCurrent);
                $newCurrentStuff->setPrevRing1($previousStuff);
                break;
        }
        $em->persist($newCurrentStuff);

    }
}
