<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Roster;
use App\Repository\InstanceRepository;
use App\Repository\LootRepository;
use App\Repository\PlayerRepository;
use App\Repository\RosterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/roster")
 */
class RosterController extends AbstractController
{

    /**
     * @Route("/new", name="roster_new", methods={"POST"})
     */
    public function register(Request $request,RosterRepository $rosterRepository, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {

        $jsonPost = $request->getContent();
        $roster = $serializer->deserialize($jsonPost, Roster::class, 'json');
        $newName = $roster->getRostername();
        $newEmail = $roster->getEmail();
        if ($rosterRepository->findOneBy(['email'=> $newEmail]) ){
            $response = JsonResponse::fromJsonString('{ "id": "1","response": "This email is already used" }', 403);
            return $response;
        }
        if ($rosterRepository->findOneBy(['rostername'=> $newName])){
            $response = JsonResponse::fromJsonString('{ "id": "2","response": "This name is already used" }', 403);
            return $response;
        }
        $roster->setRoles(['ROLE_USER']);
        $rawPassword = $roster->getPassword();
        $encode = $encoder->encodePassword($roster, $rawPassword);
        if (empty($newName) || empty($rawPassword) || empty($newEmail)){
            return JsonResponse::fromJsonString("Invalid Username or Password or Email");
        }
        $roster->setPassword($encode);
        $em->persist($roster);
        $em->flush();
        $respond = $this->json($roster, 200, [], ['groups'=> 'roster']);
        return $respond;
    }


    /**
     * @Route("/patch/{id}", name="roster_patch", methods={"PATCH"})
     */
    public function patch(Request $request, SerializerInterface $serializer,PlayerRepository $playerRepository,Roster $roster, EntityManagerInterface $em){
        $jsonPost = $request->getContent();
        $json = $serializer->decode($jsonPost, 'json');
        $playerIds = $json['playersIds'];
        foreach ($playerIds as $playerId){
            $player = $playerRepository->find($playerId);
            $roster->addPlayer($player);
            $em->persist($roster);
            $em->flush();
        }
        $respond = $this->json($json, 200, []);
        return $respond;
    }
    /**
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

    /**
     * @Route("/profile", name="roster_auth", methods={"GET"})
     */
    public function profile(PlayerRepository $playerRepository, EntityManagerInterface $em, SerializerInterface $serializer){
        $roster = $this->getUser();
//        $players = $roster->getPlayer();
//        foreach($players as $player){
//            $playerData = file_get_contents('https://xivapi.com/character/' . $player->getIdLodestone() . '?&private_key= 73c419fb32744431889a856647096edff547644c560e4200860abf6e70b710ae');
//            $playerData = $serializer->decode($playerData, 'json');
//            $playerServer = $playerData['Character']['Server'];
//            if($player->getServer() !== $playerServer){
//                $player->setServer($playerServer);
//                $em->persist($player);
//                $em->flush();
//            }
//        }
        return $this->json($roster, 200, [], ['groups'=> 'roster']);
    }
    /**
     * @Route("/currentWeekLoot", name="roster_currentWeekLoot", methods={"GET"})
     */
    public function profileCurrentWeek(EntityManagerInterface $em, InstanceRepository $instanceRepository, LootRepository $lootRepository){

        $roster = $this->getUser()->getId();
        $currentWeek = date('W');
        $conn = $em->getConnection();
        $dateCheck = date('D')==='Mon';
        if ($dateCheck){
            $currentWeek -=1;
        }
        $sql ='
SELECT item.name AS item_name,
item.id AS item_id,
instance.id AS instance_id, 
player.name AS player_name,
loot.id AS loot_id,
loot.chest,
player_job.id AS playerjob_id,
item.img_url AS item_url, 
loot.week,
instance.img_url AS instance_url,
player.img_url AS player_url,
slot.id AS slot_id,
image.imgpath AS job_img FROM instance 
INNER JOIN loot ON instance.id = loot.instance_id 
AND week = :week 
AND roster_id = :roster 
INNER JOIN player_job ON playerjob_id = player_job.id
INNER JOIN player ON player_id = player.id
INNER JOIN item ON loot.item_id = item.id
INNER JOIN job ON player_job.job_id = job.id
INNER JOIN image ON job.image_id = image.id
INNER JOIN slot ON item.slot_id = slot.id
';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['week' => $currentWeek, 'roster' => $roster]);
        $response =  $stmt->fetchAll();
//        $loots = $lootRepository->findBy(['roster'=> $roster, 'week'=> $currentWeek]);
        return $this->json($response, 200, []);
    }
    /**
     * @Route("/currentWeek", name="roster_currentWeek", methods={"GET"})
     */
    public function getWeekNumber(){
        $currentWeek = date('W');
        $dateCheck = date('D')==='Mon';
        if ($dateCheck){
            $currentWeek -=1;
        }
        return $this->json($currentWeek, 200, []);
    }
    /**
     * @Route("/{id}", name="roster_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Roster $roster): Response
    {
        if ($this->isCsrfTokenValid('delete'.$roster->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($roster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('roster_index');
    }
}
