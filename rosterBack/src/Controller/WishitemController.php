<?php

namespace App\Controller;

use App\Entity\PlayerJob;
use App\Entity\WishItem;
use App\Repository\ItemRepository;
use App\Repository\PlayerJobRepository;
use App\Repository\WishItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/wishitem")
 */
class WishitemController extends AbstractController
{

    /**
     * @Route("/{id}", name="wishlist", methods={"GET"})
     */
    public function show(WishItem $wishItem)
    {
        $response = $this->json($wishItem, 200, [], ['groups'=>'wishItem']);
        return $response;
    }

    /**
     * @Route("/{id}", name="wishitem_update", methods={"PATCH"})
     */
    public function updateGear(ItemRepository $itemRepository, WishItem $wishItem, SerializerInterface $serializer, Request $request, EntityManagerInterface $em){
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $item = $itemRepository->findOneBy(['id' => $json['itemId']]);
        $slot = $item->getSlot();
        $slotId = $slot->getId();
        if ($slotId === 1){
            $wishItem->setMainHand($item);
        }
        if ($slotId === 2){
            $wishItem->setOffHand($item);
        }
        if ($slotId === 3){
            $wishItem->setHead($item);
        }
        if ($slotId === 4){
            $wishItem->setBody($item);
        }
        if ($slotId === 5){
            $wishItem->setHands($item);
        }
        if ($slotId === 6){
            $wishItem->setBelt($item);
        }
        if ($slotId === 7){
            $wishItem->setLegs($item);
        }
        if ($slotId === 8){
            $wishItem->setFeet($item);
        }
        if ($slotId === 9){
            $wishItem->setEarring($item);
        }
        if ($slotId === 10){
            $wishItem->setNeck($item);
        }
        if ($slotId === 11){
            $wishItem->setBracelet($item);
        }
        $ring1 = $wishItem->getRing1();
        $ring2 = $wishItem->getRing2();
        if ($slotId === 12) {
            if ($ring1 == ''){
                $wishItem->setRing1($item);
            }
            if ($ring1) {
                $wishItem->setRing2($item);
            }
            if ($ring1 && $ring2){
                $wishItem->setRing1($item);
            }

        }

        $em->persist($wishItem);
        $em->flush();
        return $this->json($wishItem, 200, [], ['groups'=> 'wishItem']);
    }
}
