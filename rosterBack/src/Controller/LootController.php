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
    public function patchLootItem(Request $request, SerializerInterface $serializer,InstanceRepository $instanceRepository, PlayerJobRepository $playerJobRepository, ItemRepository $itemRepository, EntityManagerInterface $em, LootRepository $lootRepository){
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $loot = $json['id'] == NULL ? NULL : $lootRepository->findOneBy(['id'=>$json['id']]);
        $item = $itemRepository->findOneBy(['id'=> $json['item_id']]);
        $instance = $instanceRepository->findOneBy(['value'=> $json['instance']]);
        $playerJob = $playerJobRepository->findOneBy(['id'=> $json['playerjob_id']]);
        $currentWeek = date('W');
        $dateCheck = date('D')==='Mon';
        if ($dateCheck){
            $currentWeek -=1;
        }
        if ($loot){
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($item);
            $loot->setWeek($currentWeek);
        }
        else{
            $loot = new Loot();
            $loot->setChest($json['chest']);
            $loot->setRoster($this->getUser());
            $loot->setInstance($instance);
            $loot->setPlayerJob($playerJob);
            $loot->setItem($item);
            $loot->setWeek($currentWeek);
        }
        $em->persist($loot);
        $em->flush();
        return $this->json($loot, 200, [], ['groups'=> 'loots']);
    }

}
