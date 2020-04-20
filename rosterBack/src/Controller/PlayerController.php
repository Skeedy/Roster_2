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
        $response = $this->json($player, 200, [], ['groups'=>'player']);
        return $response;
    }

    /**
     * @Route("/{id}", name="player_show", methods={"GET"})
     */
    public function show(Player $player): Response
    {
        $respond = $this->json($player, 200, [], ['groups'=>'player']);
        return $respond;
    }

    /**
     * @Route("/new", name="player_new", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, JobRepository $jobRepository, EntityManagerInterface $em, PlayerJobRepository $playerJob): Response
    {
        $jsonPost = $request->getContent();
        $player = $serializer->deserialize($jsonPost, Player::class, 'json');
        $playerLod = $player->getIDLodestone();
        $playerData = file_get_contents('https://xivapi.com/character/'. $playerLod .'?&private_key='. APIKey);
        $playerData = $serializer->decode($playerData, 'json');
        $playername = $playerData['Character']['Name'];
        $playerServer = $playerData['Character']['Server'];
        $player->setName($playername);
        $player->setServer($playerServer);
        $em->persist($player);
        $em->flush();


        $respond = $this->json($player, 200, []);
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
