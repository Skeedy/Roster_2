<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerJob;
use App\Repository\ItemRepository;
use App\Repository\PlayerJobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/playerjob")
 */
class PlayerjobController extends AbstractController
{
    /**
     * @Route("/", name="playerjob", methods={"GET"})
     */
    public function index(PlayerJobRepository $playerJobRepository)
    {
        $playerjobs = $playerJobRepository->findAll();
        $response = $this->json($playerjobs, 200, [], ['groups'=>'job']);
        return $response;
    }
    /**
     * @Route("/{id}", name="playerjob", methods={"GET"})
     */
    public function show(PlayerJob $playerJob)
    {
        $response = $this->json($playerJob, 200, [], ['groups'=>'wishItem']);
        return $response;
    }
    /**
     * @Route("/{id}", name="playerjob_delete", methods={"DELETE"})
     */
    public function delete(PlayerJob $playerjob, PlayerJobRepository $playerJobRepository, EntityManagerInterface $em){
        if ($playerjob){
            $player = $playerjob->getPlayer();
            $playerjobList = $player->getPlayerJobs();
            $i = 0;
            $em->remove($playerjob);
            $em->flush();
            foreach ($playerjobList as $job){
                $job->setOrd($job->getIsMain() ? 0 : $i);
                $i++;
            }
            $em->persist($job);
            $em->flush();
        }
        $response = JsonResponse::fromJsonString('{ "response": "the job has been deleted" }', 200);
        return $response;
    }

    /**
     * @Route("/patchgear/{id}", name="playerjob_patch", methods={"PATCH"})
     */

    /*
    public function updateGear(ItemRepository $itemRepository, PlayerJob $playerjob, SerializerInterface $serializer, Request $request, EntityManagerInterface $em){
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $slotId = $json['slotId'];
        $item = $itemRepository->findOneBy(['id' => $json['itemId']]);
        if ($slotId === 1){
//            $playerjob->setWishWeapon($item);
        }
        if ($slotId === 2){
//            $playerjob->setWishWeapon($item);
        }
        if ($slotId === 3){
            $playerjob->setWishHead($item);
        }
        if ($slotId === 4){
            $playerjob->setWishBody($item);
        }
        if ($slotId === 5){
            $playerjob->setWishHand($item);
        }
        if ($slotId === 6){
            $playerjob->setWishWaist($item);
        }
        if ($slotId === 7){
            $playerjob->setWishLeg($item);
        }
        if ($slotId === 8){
            $playerjob->setWishFeet($item);
        }
        if ($slotId === 9){
            $playerjob->setWishEarring($item);
        }
        if ($slotId === 10){
            $playerjob->setWishNeck($item);
        }
        if ($slotId === 11){
            $playerjob->setWishBracelet($item);
        }
        if ($slotId === 12){
            $playerjob->setWishRing1($item);
        }
        if ($slotId === 13){
            $playerjob->setWishRing2($item);
        }
        $em->persist($playerjob);
        $em->flush();
        return JsonResponse::fromJsonString('{"response" :"Fait !"}', 200);
    }
    */
}
