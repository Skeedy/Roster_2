<?php

namespace App\Controller;

use App\Entity\Item;
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
    /**
     * @Route("/", name="item_index", methods={"GET"})
     */
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findBy(
            ['jobType'=> 'Fending']);
        $respond = $this->json($items, 200, []);
        return $respond;
    }

    /**
     * @Route("/updateItem", name="item_update", methods={"POST", "PATCH"})
     */
    public function updateItems(ItemRepository $itemRepository, EntityManagerInterface $em, SerializerInterface $serializer){
        $ilvl = isset($_GET['ilvl'])? $_GET['ilvl'] : '';
        if($ilvl) {
            $rawDatas = file_get_contents('https://xivapi.com/search?filters=LevelItem=' . $ilvl . '&private_key=73c419fb32744431889a856647096edff547644c560e4200860abf6e70b710ae');
            $datas = $serializer->decode($rawDatas, 'json');
            $nbPage = $datas['Pagination']['PageTotal'];
            for ($i = 1; $i <= $nbPage; $i++) {
                $page = '&page='. $i;
                $this->patchLoop($itemRepository, $ilvl, $em, $page, $serializer);
            }
            return JsonResponse::fromJsonString($page);
        }
        else{
            return JsonResponse::fromJsonString('no ilvl determined');
        }
    }
    public function patchLoop($itemRepository, $ilvl, $em, $page, $s){
        $rawDatas = file_get_contents('https://xivapi.com/search?filters=LevelItem=' . $ilvl . $page. '&private_key=73c419fb32744431889a856647096edff547644c560e4200860abf6e70b710ae');
        $datas = $s->decode($rawDatas, 'json');
        $savageName = 'dench';
        foreach ($datas['Results'] as $data){
            $check= $itemRepository->findOneBy(['LodId' => $data['ID']]);
            if(!$check) {
                $item = new Item();
                $itemName = $data['Name'];
                $checkSavage = strpos($itemName, $savageName);
                $item->setName($itemName);
                $item->setImgUrl('https://xivapi.com' . $data['Icon']);
                $item->setIlvl($ilvl);
                $pieces = explode(' ', $itemName);
                $last_word = array_pop($pieces);
                $jobType = null;
                switch ($last_word) {
                    case 'Casting':
                       $jobType = 'Casting';
                        break;
                    case 'Fending':
                        $jobType = 'Fending';
                        break;
                    case 'Maiming':
                        $jobType = 'Maiming';
                        break;
                    case 'Striking':
                        $jobType = 'Striking';
                        break;
                    case 'Healing':
                        $jobType = 'Healing';
                        break;
                    case 'Scouting':
                        $jobType = 'Scouting';
                        break;
                    case 'Aiming':
                        $jobType = 'Aiming';
                }
                $item->setIsSavage($checkSavage);
                $item->setLodId($data['ID']);
                $item->setJobType($jobType);
                $em->persist($item);
                $em->flush();
            }
        }
    }
}
