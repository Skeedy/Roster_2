<?php

namespace App\Controller;

use App\Entity\CurrentStuff;
use App\Entity\OldStuff;
use App\Entity\PlayerJob;
use App\Entity\WishItem;
use App\Repository\CurrentStuffRepository;
use App\Repository\ItemRepository;
use App\Repository\JobRepository;
use App\Repository\LootRepository;
use App\Repository\OldstuffRepository;
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
        $playersId = $serializer->decode($jsonPost, 'json')['playersIds'][0]; // récupère l'id du personnage
        $roster = $this->getUser(); // récupère le roster
        $player = $playerRepository->findOneBy(['IDLodestone' => $playersId]); // recherche si le personnage existe
        // si oui, erreur
        if ($player) {
            $response = JsonResponse::fromJsonString('{"response": "' . $player->getName() .  ' is already in a roster" }', 403);
            return $response;
            // sinon l'enregistre
        } else {
            // créer une nouvelle instance de personnage
            $player = new Player();
            // envoie une requête avec l'identifiant et la clef API
            $playerData = file_get_contents('https://xivapi.com/character/' . $playersId . '?&private_key=' . APIKey);
            $playerData = $serializer->decode($playerData, 'json');
            // récupère toute les information neccessaires
            $playername = $playerData['Character']['Name'];
            $playerServer = $playerData['Character']['Server'];
            $playerImg = $playerData['Character']['Avatar'];
            $playerPortrait = $playerData['Character']['Portrait'];
            // enregistre dans la base de données
            $player->setImgUrl($playerImg);
            $player->setPortrait($playerPortrait);
            $player->setIDLodestone($playersId);
            $player->setName($playername);
            $player->setServer($playerServer);
            $player->setRoster($roster);
            $em->persist($player);
            $em->flush();
            $respond = JsonResponse::fromJsonString('{"response": "'.$playername. ' is registred !"}', 200);
            return $respond;
        }
    }


    /**
     * @Route("/patch/{id}", name="player_patch", methods={"PATCH"})
     */
    public function patch(Request $request,
                          SerializerInterface $serializer,
                          PlayerJobRepository $playerJobRepository,
                          Player $player,
                          JobRepository $jobRepository,
                          SlotRepository $slotRepository,
                          ItemRepository $itemRepository,
                          EntityManagerInterface $em)
    {
        $json = $request->getContent();
        $json = $serializer->decode($json, 'json');
        // récupère l'entité
        $playerJob = $playerJobRepository->findOneBy(['id' => $json['ddbId']]);
        // récupère l'entité du job à ajouter/modifier
        $jobfetch = $jobRepository->findOneBy(['id' => $json['job']]);
        $jobId = $jobfetch->getId();
        // si il existe
        if (count($player->getPlayerJobs()) < 5 || $playerJob) {
            $jobs = $player->getPlayerJobs();
            // boucle pour vérifier si il n'est pas déjà utilisé et renvoie une erreur
            foreach ($jobs as $job) {
                if ($job->getJob() === $jobfetch) {
                    $response = JsonResponse::fromJsonString('{"error" : true, "response":"This job is already in use"}', 403);
                    return $response;
                }
            }
            if($playerJob){
                // si pas d'erreur
                // supprime toutes les instances de liste d'équipement
                $em->remove($playerJob->getWishItem());
                $em->remove($playerJob->getCurrentstuff());
                $em->remove($playerJob->getOldStuff());
            }
            if(!$playerJob){
                $playerJob = new PlayerJob();
                $playerJob->setPlayer($player);
                $ordcount = count($player->getPlayerJobs());
                $playerJob->setOrd($ordcount === 0 ? 0 : $ordcount);
            }
            // créer une nouvelle instance de wishlist
            $newWishItem = new WishItem();
            // créer une instance de stuff courrant
            $newCurrentStuff = new CurrentStuff();
            //créer une instance de "vieux stuff"
            $newOldStuff = new OldStuff();
            // met les objets par défault sur la wishlist
            $newWishItem->setRing1($this->findRing(true, $jobId, $itemRepository, $slotRepository));
            $newWishItem->setRing2($this->findRing(false, $jobId, $itemRepository, $slotRepository));
            // assigne les instances crées à l'entité playerJob
            $playerJob->setOldStuff($newOldStuff);
            $playerJob->setCurrentstuff($newCurrentStuff);
            $playerJob->setWishItem($newWishItem);
            // assigne le job
            $playerJob->setJob($jobfetch);
            // assigne si c'est un main ou sub
            $playerJob->setIsMain($json['isMain']);
            // ça c'est à corriger, c'est inutile
            $playerJob->setIsSub($json['isSub']);
            // assigne le joueur
            // enregistre toute les instances crées
            $em->persist($playerJob);
            $em->persist($newOldStuff);
            $em->persist($newCurrentStuff);
            $em->persist($newWishItem);
            $em->flush();
            $respond = $this->json($json, 200, []);
            return $respond;
            // si il n'existe pas
        }
        else {
            $response = JsonResponse::fromJsonString('{"error" : true, "response":"Only 5 jobs are allowed for now"}', 403);
            return $response;
        }
    }
/**
 * @Route("/{id}", name="player_delete", methods={"DELETE"})
 */
public function delete(Player $player, EntityManagerInterface $em, LootRepository $lootRepository)
{
    // vérifie si le user appartien bien au roster connecté
    if ($this->getUser() == $player->getRoster()) {
        // si le joueur existe
        if ($player) {
            $playerjobs = $player->getPlayerJobs();
            foreach ($playerjobs as $playerjob) {
                // récupère ses jobs
                $playerjobID = $playerjob->getId();
                // récupère les butins obtenus
                $loots = $lootRepository->findBy(['playerjob' => $playerjobID]);
                foreach ($loots as $loot) {
                    // efface tout ses loots
                    $em->remove($loot);
                    $em->flush();
                }
            }
            // supprime le personnage de la BDD
            $em->remove($player);
            $em->flush();
            $response = JsonResponse::fromJsonString('{ "response": "' . $player->getName() . ' has been removed" }', 200);
            return $response;
        }
        // si existe pas
        else{
            JsonResponse::fromJsonString('{ "response": " Player does not exist" }', 401);
        }
    }
    // par sécurité, si quelqu'un trouve comment marche mes requêtes
    else{
        return JsonResponse::fromJsonString('{ "response": "This player does not belong to your roster" }', 403);
    }
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
