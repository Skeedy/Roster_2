<?php

namespace App\Controller;

use App\Entity\CurrentStuff;
use App\Entity\OldStuff;
use App\Entity\PlayerJob;
use App\Entity\WishItem;
use App\Repository\ItemRepository;
use App\Repository\JobRepository;
use App\Repository\LootRepository;
use App\Repository\PlayerJobRepository;
use App\Repository\RosterRepository;
use App\Repository\SlotRepository;
use App\Repository\WishItemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Player;
use App\Repository\PlayerRepository;

define('APIKey', '619d5d66075843a49bfb76c7d87cc412333c8d75389e47b8a17eac66c5109a7c');

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="player", methods={"GET"})
     */
    public function index(PlayerRepository $playerRepository)
    {
        $player = $playerRepository->findAll();
        $response = $this->json($player, 200, [], ['groups' => 'player']);
        return $response;
    }

    /**
     * @Route("/{id}", name="player_show", methods={"GET"})
     */
    public function show(Player $player): Response
    {

        $respond = $this->json($player, 200, [], ['groups' => 'playerloot']);
        return $respond;
    }

    /**
     * @Route("/new", name="player_new", methods={"POST"})
     */
    public function new(Request $request,RosterRepository$rosterRepository, SerializerInterface $serializer, EntityManagerInterface $em, PlayerRepository $playerRepository): Response
    {
        $jsonPost = $request->getContent();
        $playersIds = $serializer->decode($jsonPost, 'json')['playersIds'];
        $rosterID = $serializer->decode($jsonPost, 'json')['rosterID'];
        $roster = $rosterRepository->findOneBy(['id'=> $rosterID]);
        $i = 0;
        $nbError = 0;
        $error = false;
        foreach ($playersIds as $playersId) {
            $check[$i] = $playerRepository->findOneBy(['IDLodestone' => $playersId]);
            if ($check[$i]) {
                $error = true;
                $nbError ++;
                $stringError = '';
                $names[$i] = $check[$i]->getName();
                foreach ($names as $name) {
                    $stringError .= $name . ($i == count($playersIds) ? ' ' : ', ');
                }
            }
            $i++;
        }
        if ($error) {
            $response = JsonResponse::fromJsonString('{"response": "' . $stringError . ($nbError>1 ? 'are': 'is').' already in a roster" }', 403);
            return $response;
        } else {
            foreach ($playersIds as $playersId) {
                $player = new Player();
                $playerData = file_get_contents('https://xivapi.com/character/' . $playersId . '?&private_key=' . APIKey);
                $playerData = $serializer->decode($playerData, 'json');
                $playername = $playerData['Character']['Name'];
                $playerServer = $playerData['Character']['Server'];
                $playerImg = $playerData['Character']['Avatar'];
                $playerPortrait = $playerData['Character']['Portrait'];
                $player->setImgUrl($playerImg);
                $player->setPortrait($playerPortrait);
                $player->setIDLodestone($playersId);
                $player->setName($playername);
                $player->setServer($playerServer);
                $player->setRoster($roster);
                $em->persist($player);
                $em->flush();
            }
            $respond = JsonResponse::fromJsonString('{"response": "All players are registred !"}', 200);
            return $respond;
        }
    }


    /**
     * @Route("/patch/{id}", name="player_patch", methods={"PATCH"})
     */
    public function patch(Request $request,
                          SerializerInterface $serializer,
                          WishItemRepository $wishItemRepository,
                          PlayerJobRepository $playerJobRepository,
                          Player $player,
                          JobRepository $jobRepository,
                          SlotRepository $slotRepository,
                          ItemRepository $itemRepository,
                          EntityManagerInterface $em){
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $playerJob = $playerJobRepository->findOneBy(['id' => $json['ddbId']]);
        $jobfetch = $jobRepository->findOneBy(['id' =>$json['job']]);
        $jobId = $jobfetch->getId();
        if(count($player->getPlayerJobs()) < 5) {
            if ($playerJob) {
                $jobs = $player->getPlayerJobs();
                foreach ($jobs as $job) {
                    if ($job->getJob() === $jobfetch) {
                        $response = JsonResponse::fromJsonString('{"error" : true, "response":"This job is already in use"}', 403);
                        return $response;
                    }
                }

                $wishItem = $wishItemRepository->find($playerJob->getWishItem()->getId());
                $playerJob->setWishItem(NULL);
                $em->remove($wishItem);
                $newWishItem = new WishItem();
                $newWishItem->setRing1($this->findRing(true, $jobId, $itemRepository, $slotRepository));
                $newWishItem->setRing2($this->findRing(false, $jobId, $itemRepository, $slotRepository));
                $newCurrentStuff = new CurrentStuff();
                $newOldStuff = new OldStuff();
                $playerJob->setOldStuff($newOldStuff);
                $playerJob->setCurrentstuff($newCurrentStuff);
                $playerJob->setWishItem($newWishItem);
                $playerJob->setJob($jobfetch);
                $playerJob->setIsMain($json['isMain']);
                $playerJob->setIsSub($json['isSub']);
                $playerJob->setPlayer($player);
                $em->persist($playerJob);
                $em->persist($newWishItem);
                $em->flush();
                $respond = $this->json($json, 200, []);
                return $respond;
            }

            $playerJob = new PlayerJob();
            $newWishItem = new WishItem();
            $currentStuff = new CurrentStuff();
            $newOldStuff = new OldStuff();
            $newWishItem->setRing1($this->findRing(true, $jobId, $itemRepository, $slotRepository));
            $newWishItem->setRing2($this->findRing(false, $jobId, $itemRepository, $slotRepository));
            $playerJob->setOldStuff($newOldStuff);
            $ordcount = count($player->getPlayerJobs());
            $playerJob->setWishItem($newWishItem);
            $playerJob->setCurrentstuff($currentStuff);
            $playerJob->setPlayer($player);
            $playerJob->setJob($jobfetch);
            $playerJob->setOrd($ordcount === 0 ? 0 : $ordcount);
            $playerJob->setIsMain($json['isMain']);
            $playerJob->setIsSub($json['isSub']);
            $em->persist($playerJob);
            $em->persist($newWishItem);
            $em->flush();
            $respond = $this->json($json, 200, []);
            return $respond;
        }
        else{
            $response = JsonResponse::fromJsonString('{"error" : true, "response":"5 jobs are allowed for now"}', 403);
            return $response;
        }
}
/**
 * @Route("/{id}", name="player_delete", methods={"DELETE"})
 */
public function delete(Player $player, EntityManagerInterface $em, LootRepository $lootRepository){
    if ($player){
        $playerjobs = $player->getPlayerJobs();
        foreach ($playerjobs as $playerjob) {
            $playerjobID = $playerjob->getId();
            $loots = $lootRepository->findBy(['playerjob'=> $playerjobID]);
            foreach ($loots as $loot) {
                $em->remove($loot);
                $em->flush();
            }
        }
        $em->remove($player);
        $em->flush();
    }
    $response = JsonResponse::fromJsonString('{ "response": "'. $player->getName() .' has been deleted" }', 200);
    return $response;
}
public function findRing($isSavage, $jobId, ItemRepository $itemRepository, SlotRepository $slotRepository){
    $slotId = $slotRepository->findOneBy(["name"=> "finger"])->getId();
    $items = $itemRepository->findBy(['slot'=> $slotId, 'ilvl' => 530, 'isSavage' => $isSavage]);
    foreach ($items as $item){
        foreach ($item->getJobs() as $job)
            if($jobId === $job->getId()) {
                return $item;
            }
    }
}
}
