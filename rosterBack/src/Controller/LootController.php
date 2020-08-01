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
        $currentStuff = $playerJob->getCurrentstuff();
        $currentWeek = date('W');
        $dateCheck = date('D') === 'Mon';
        $job = $playerJob->getJob();
        $slot = $itemChest->getSlot();
        $items = $job->getItems();
        $itemToAssignCurrent ='';
        foreach ($items as $item){
            if($item->getSlot() === $slot && $item->getIlvl() == 500){
                $itemToAssignCurrent = $item;
            }
        }
        if ($dateCheck) {
            $currentWeek -= 1;
        }
        if ($loot) {
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($item);
            $loot->setWeek($currentWeek);
            $this->setItemIntoCurrentstuff($slot, $currentStuff, $itemToAssignCurrent, $em);

        } else {
            $loot = new Loot();
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($item);
            $loot->setWeek($currentWeek);
            $this->setItemIntoCurrentstuff($slot, $currentStuff, $itemToAssignCurrent, $em);
        }
        $em->persist($loot);
        $em->flush();
        return $this->json($itemToAssignCurrent, 200, [], ['groups' => 'loots']);
    }

    public function setItemIntoCurrentstuff($slotId, $currentStuff, $itemToAssignCurrent, $em)
    {
        switch ($slotId) {
            case 1 :
                $currentStuff->setMainHand($itemToAssignCurrent);
                break;
            case 2 :
                $currentStuff->setOffHand($itemToAssignCurrent);

                break;
            case 3 :
                $currentStuff->setHead($itemToAssignCurrent);
                break;
            case 4 :
                $currentStuff->setBody($itemToAssignCurrent);
                break;
            case 5 :
                $currentStuff->setHands($itemToAssignCurrent);
                break;
            case 6 :
                $currentStuff->setBelt($itemToAssignCurrent);
                break;
            case 7 :
                $currentStuff->setLegs($itemToAssignCurrent);
                break;
            case 8 :
                $currentStuff->setFeet($itemToAssignCurrent);
                break;
            case 9 :
                $currentStuff->setEarring($itemToAssignCurrent);
                break;
            case 10 :
                $currentStuff->setNeck($itemToAssignCurrent);
                break;
            case 11 :
                $currentStuff->setBracelet($itemToAssignCurrent);
                break;
            case 12 :
                $currentStuff->setRing1($itemToAssignCurrent);
                break;
        }
        $em->persist($currentStuff);
    }
}
