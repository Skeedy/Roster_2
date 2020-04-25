<?php

namespace App\Controller;

use App\Entity\PlayerJob;
use App\Repository\JobRepository;
use App\Repository\PlayerJobRepository;
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

define('APIKey', '73c419fb32744431889a856647096edff547644c560e4200860abf6e70b710ae');

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
        $respond = $this->json($player, 200, [], ['groups' => 'player']);
        return $respond;
    }

    /**
     * @Route("/new", name="player_new", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, PlayerRepository $playerRepository): Response
    {
        $jsonPost = $request->getContent();
        $playersIds = $serializer->decode($jsonPost, 'json')['playersIds'];
        $i = 0;
        foreach ($playersIds as $playersId) {
            $check[$i] = $playerRepository->findOneBy(['IDLodestone' => $playersId]);
            if ($check[$i]) {
                $stringError = '';
                $names[$i] = $check[$i]->getName();
                foreach ($names as $name) {
                    $stringError .= $name . ' ';
                }
                $response = JsonResponse::fromJsonString('{"response": "' . $stringError . ' is already in a roster" }', 403);
                return $response;
            } else {
                $player = new Player();
                $playerData = file_get_contents('https://xivapi.com/character/' . $playersId . '?&private_key=' . APIKey);
                $playerData = $serializer->decode($playerData, 'json');
                $playername = $playerData['Character']['Name'];
                $playerServer = $playerData['Character']['Server'];
                $player->setIDLodestone($playersId);
                $player->setName($playername);
                $player->setServer($playerServer);
                $em->persist($player);
                $em->flush();
            }
            $i++;
        }
        $respond = $this->json($i, 200, []);
        return $respond;
    }


    /**
     * @Route("/patch/{id}", name="player_patch", methods={"PATCH"})
     */
    public function patch(Request $request, SerializerInterface $serializer,PlayerRepository $playerRepository, Player $player, JobRepository $jobRepository, EntityManagerInterface $em){
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        $jobList = $json['playerJobs'];
        $playerId = $playerRepository->find($json['id']);
        foreach ($jobList as $job){
            $playerJob = new PlayerJob();
            $jobId = $jobRepository->find($job['job']);
            $playerJob->setJob($jobId);
            $playerJob->setIsMain($job['isMain']);
            $playerJob->setIsSub($job['isSub']);
            $playerJob->setPlayer($playerId);
            $em->persist($playerJob);
        }
        $em->flush();
        $respond = $this->json($json, 200, []);
        return $respond;
    }
}
