<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\InstanceRepository;
use App\Repository\JobRepository;
use App\Repository\SlotRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/item")
 */
class ItemController extends AbstractController
{
    public function strpos_arr($haystack, $needle) {
        if(!is_array($needle)) $needle = array($needle);
        foreach($needle as $what) {
            if(($pos = strpos($haystack, $what))!==false) return $pos;
        }
        return false;
    }
    /**
     * @Route("/", name="item_index", methods={"GET"})
     */
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();
        $respond = $this->json($items, 200, [], ['groups' => 'item']);
        return $respond;
    }

    /**
     * @Route("/updateItem", name="item_update", methods={"POST", "PATCH"})
     */
    public function updateItems(ItemRepository $itemRepository,JobRepository $jobRepository, EntityManagerInterface $em, SerializerInterface $serializer, SlotRepository $slotRepository, InstanceRepository $instanceRepository){
        $ilvl = isset($_GET['ilvl'])? $_GET['ilvl'] : '';
        if($ilvl) {
            $rawDatas = file_get_contents('https://xivapi.com/search?filters=LevelItem=' . $ilvl . '&columns=Name,ID,EquipSlotCategoryTargetID,ClassJobUseTargetID,Icon,LevelItem&limit=3000&private_key=73c419fb32744431889a856647096edff547644c560e4200860abf6e70b710ae');
            $datas = $serializer->decode($rawDatas, 'json');
            $nbItems = 0;
            foreach ($datas['Results'] as $data){
                $check= $itemRepository->findOneBy(['LodId' => $data['ID']]);
                if(!$check) {
                    $item = new Item();
                    $itemName = $data['Name'];
                    $savageName = 'dench';
                    $book = "ook";
                    $upgrade = ['Twine', 'Ester', 'Glaze'];
                    $checkSavage = strpos($itemName, $book) || strpos($itemName, $savageName) || $this->strpos_arr($itemName, $upgrade);
                    $coffer = "Coffer";
                    $item->setName($itemName);
                    $item->setImgUrl('https://xivapi.com' . $data['Icon']);
                    $item->setIlvl($ilvl);
                    $pieces = explode(' ', $itemName);
                    $last_word = array_pop($pieces);
                    $jobType = null;
                    switch ($last_word) {
                        case 'Casting':
                            $jobType = 'Casting';
                            $jobs = $jobRepository->findBy(['id'=> [16,17,18]]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                            break;
                        case 'Fending':
                            $jobType = 'Fending';
                            $jobs = $jobRepository->findBy(['id'=> [2,3,4,5]]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                            break;
                        case 'Maiming':
                            $jobType = 'Maiming';
                            $jobs = $jobRepository->findBy(['id'=> 10]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                            break;
                        case 'Striking':
                            $jobType = 'Striking';
                            $jobs = $jobRepository->findBy(['id'=> [9,12]]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                            break;
                        case 'Healing':
                            $jobType = 'Healing';
                            $jobs = $jobRepository->findBy(['id'=> [6,7,8]]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                            break;
                        case 'Scouting':
                            $jobType = 'Scouting';
                            $jobs = $jobRepository->findBy(['id'=> [11]]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                            break;
                        case 'Aiming':
                            $jobType = 'Aiming';
                            $jobs = $jobRepository->findBy(['id'=> [13,14,15]]);
                            foreach ($jobs as $job){
                                $item->addJob($job);
                            }
                    }
                    $convertSlotId = $data['EquipSlotCategoryTargetID'] === 13 ? 1 : $data['EquipSlotCategoryTargetID'];
                    $slot = $slotRepository->findOneBy(['lodId' => $convertSlotId]);
                    $item->setSlot($convertSlotId === 0 ? null : $slot);
                    if($data['ClassJobUseTargetID'] !== 0 || $data['EquipSlotCategoryTargetID'] == 2){
                        if ($data['ClassJobUseTargetID'] !== 0) {
                            $job = $jobRepository->findOneBy(['lodId' => $data['ClassJobUseTargetID']]);
                        }
                        if ($data['EquipSlotCategoryTargetID'] == 2){
                            $job = $jobRepository->findOneBy(['lodId' => 1]);
                        }
                        $item->addJob($job);
                    }
                    $item->setIsSavage($checkSavage);
                    $item->setLodId($data['ID']);
                    $item->setJobType($jobType);
                    $em->persist($item);
                    $em->flush();
                    $raid1 = ['Waist','Earring','Necklace','Bracelet','Ring'];
                    $raid2 = ['Head','Hand','Foot', 'Glaze'];
                    $raid3 = ['Head','Hand','Foot', 'Leg', 'Twine', 'Ester'];
                    $raid4 = ['Weapon','Chest'];
                    if(strpos($itemName,$coffer) || $this->strpos_arr($itemName,$upgrade)){
                        if($this->strpos_arr($itemName, $raid1)){
                            $instance = $instanceRepository->findOneBy(['value' => 1]);
                            $instance->addItem($item);
                        }
                        if($this->strpos_arr($itemName, $raid2)){
                            $instance = $instanceRepository->findOneBy(['value' => 2]);
                            $instance->addItem($item);
                        }
                        if($this->strpos_arr($itemName, $raid3)){
                            $instance = $instanceRepository->findOneBy(['value' => 3]);
                            $instance->addItem($item);
                        }
                        if($this->strpos_arr($itemName, $raid4)){
                            $instance = $instanceRepository->findOneBy(['value' => 4]);
                            $instance->addItem($item);
                        }
                        $em->persist($instance);
                        $em->flush();
                    }
                    $nbItems ++;
                }
            }
            return JsonResponse::fromJsonString('{'.$nbItems.' items have been created}');
        }
        else{
            return JsonResponse::fromJsonString('no ilvl determined');
        }
    }

//    public function patchLoop($itemRepository, $ilvl, $em, $page, $s, $slotRepository){
//        $rawDatas = file_get_contents('https://xivapi.com/search?filters=LevelItem=' . $ilvl . $page. '&columns=Name,ID,EquipSlotCategoryTargetID,Icon,LevelItem&private_key=73c419fb32744431889a856647096edff547644c560e4200860abf6e70b710ae');
//        $datas = $s->decode($rawDatas, 'json');
//        foreach ($datas['Results'] as $data){
//            $check= $itemRepository->findOneBy(['LodId' => $data['ID']]);
//            if(!$check) {
//                $item = new Item();
//                $itemName = $data['Name'];
//                $savageName = 'dench';
//                $book = "ook";
//                $upgrade = "rystalline";
//                $checkSavage = strpos($itemName, $book) || strpos($itemName, $savageName) || strpos($itemName, $upgrade);
//                $item->setName($itemName);
//                $item->setImgUrl('https://xivapi.com' . $data['Icon']);
//                $item->setIlvl($ilvl);
//                $pieces = explode(' ', $itemName);
//                $last_word = array_pop($pieces);
//                $jobType = null;
//                switch ($last_word) {
//                    case 'Casting':
//                        $jobType = 'Casting';
//                        break;
//                    case 'Fending':
//                        $jobType = 'Fending';
//                        break;
//                    case 'Maiming':
//                        $jobType = 'Maiming';
//                        break;
//                    case 'Striking':
//                        $jobType = 'Striking';
//                        break;
//                    case 'Healing':
//                        $jobType = 'Healing';
//                        break;
//                    case 'Scouting':
//                        $jobType = 'Scouting';
//                        break;
//                    case 'Aiming':
//                        $jobType = 'Aiming';
//                }
//                $convertSlotId = $data['EquipSlotCategoryTargetID'] === 13 ? 1 : $data['EquipSlotCategoryTargetID'];
//                $slot = $slotRepository->findOneBy(['lodId' => $convertSlotId]);
//                $item->setSlot($convertSlotId === 0 ? null : $slot);
//                $item->setIsSavage($checkSavage);
//                $item->setLodId($data['ID']);
//                $item->setJobType($jobType);
//                $em->persist($item);
//                $em->flush();
//            }
//        }
//    }
}
