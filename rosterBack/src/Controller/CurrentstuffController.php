<?php

namespace App\Controller;

use App\Entity\CurrentStuff;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/currentstuff")
 */
class CurrentstuffController extends AbstractController
{

    /**
     * @Route("/{id}", name="currentstuff", methods={"GET"})
     */
    public function show(CurrentStuff $currentStuff)
    {
        $response = $this->json($currentStuff, 200, [], ['groups'=>'currentStuff']);
        return $response;
    }

    /**
     * @Route("/{id}", name="currentstuff_update", methods={"PATCH"})
     */
    public function updateGear(ItemRepository $itemRepository, CurrentStuff $currentStuff, SerializerInterface $serializer, Request $request, EntityManagerInterface $em){
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $item = $itemRepository->findOneBy(['id' => $json['itemId']]);
        $slot = $item->getSlot();
        $slotId = $slot->getId();
        if ($slotId === 1){
            $currentStuff->setMainHand($item);
        }
        if ($slotId === 2){
            $currentStuff->setOffHand($item);
        }
        if ($slotId === 3){
            $currentStuff->setHead($item);
        }
        if ($slotId === 4){
            $currentStuff->setBody($item);
        }
        if ($slotId === 5){
            $currentStuff->setHands($item);
        }
        if ($slotId === 6){
            $currentStuff->setBelt($item);
        }
        if ($slotId === 7){
            $currentStuff->setLegs($item);
        }
        if ($slotId === 8){
            $currentStuff->setFeet($item);
        }
        if ($slotId === 9){
            $currentStuff->setEarring($item);
        }
        if ($slotId === 10){
            $currentStuff->setNeck($item);
        }
        if ($slotId === 11){
            $currentStuff->setBracelet($item);
        }
        $ring1 = $currentStuff->getRing1();
        $ring2 = $currentStuff->getRing2();
        if ($slotId === 12) {
            if ($ring1 == NULL){
                $currentStuff->setRing1($item);
            }
            if ($ring1) {
                $currentStuff->setRing2($item);
            }
            if ($ring1 && $ring2){
                $currentStuff->setRing1($item);
            }

        }

        $em->persist($currentStuff);
        $em->flush();
        return $this->json($currentStuff, 200, [], ['groups'=> 'wishItem']);
    }
}
