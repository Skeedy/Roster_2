<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Roster;
use App\Entity\Week;
use App\Repository\InstanceRepository;
use App\Repository\LootRepository;
use App\Repository\PlayerRepository;
use App\Repository\RosterRepository;
use App\Repository\WeekRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/roster")
 */
class RosterController extends AbstractController
{

    /**
     * @Route("/register", name="roster_register", methods={"POST"})
     */
    public function register(Request $request,RosterRepository $rosterRepository, MailerInterface $mailer, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        // récupère le JSON du formulaire
        $jsonPost = $request->getContent();
        // deserialiaze et le transforme en instance de Roster
        $roster = $serializer->deserialize($jsonPost, Roster::class, 'json');
        // récupère le nom pour regarder si il n'existe pas déjà
        $newName = $roster->getRostername();
        // pareil mais pour l'email
        $newEmail = $roster->getEmail();
        // si nom existe, erreur
        if ($rosterRepository->findOneBy(['email'=> $newEmail]) ){
            $response = JsonResponse::fromJsonString('{ "id": "1","response": "This email is already used" }', 401);
            return $response;
        }
        // si email existe
        if ($rosterRepository->findOneBy(['rostername'=> $newName])){
            $response = JsonResponse::fromJsonString('{ "id": "2","response": "This name is already used" }', 401);
            return $response;
        }
        // défini le role de l'utilisateur
        $roster->setRoles(['ROLE_USER']);
        // récupère le pasword et l'encode
        $rawPassword = $roster->getPassword();
        $encode = $encoder->encodePassword($roster, $rawPassword);
        if (empty($newName) || empty($rawPassword) || empty($newEmail)){
            return JsonResponse::fromJsonString("Invalid Username or Password or Email");
        }
        $roster->setPassword($encode);
        $roster->setIsVerified(false); // En attente de confirmation de mail
        $roster->setTokenPassword(NULL); // rentre aucun token pour changer le mot de passe
        $em->persist($roster);
        $em->flush(); // Enregistre dans la base de données
        // créer une instance de mail
        $email = (new TemplatedEmail())
            ->from('rosterffxiv@gmail.com')
            ->to(new Address($newEmail))
            ->subject('Welcome to FFXIVRoster!')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'roster' => $roster,
            ]);
        // envoie le mail
        $mailer->send($email);

        $respond = JsonResponse::fromJsonString('{ "response": "Roster created !" }', 200);
        return $respond;
    }


    /**
     * @Route("/patch/", name="roster_patch", methods={"PATCH"})
     */
    public function patch(Request $request, SerializerInterface $serializer,PlayerRepository $playerRepository,EntityManagerInterface $em){
        $jsonPost = $request->getContent();
        $roster = $this->getUser();
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

    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        if($user->isVerified()){
            return new JsonResponse(['token' => $JWTManager->create($user)]);
        }
    }

    /**
     * @Route("/profile", name="roster_auth", methods={"GET"})
     */
    public function profile(PlayerRepository $playerRepository, EntityManagerInterface $em, SerializerInterface $serializer){
        $roster = $this->getUser();
        return $this->json($roster, 200, [], ['groups'=> 'roster']);

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

    }
    /**
     * @Route("/currentWeekLoot", name="roster_currentWeekLoot", methods={"GET"})
     */
    public function profileCurrentWeek(EntityManagerInterface $em, WeekRepository $weekRepository){

        $roster = $this->getUser()->getId();
        $currentWeek = date('W');
        $conn = $em->getConnection();
        $dateCheck = date('D')==='Mon';
        if ($dateCheck){
            $currentWeek -=1;
        }
        if (!$weekRepository->findOneBy(['value'=> $currentWeek])){
            $newWeek = new Week();
            $newWeek->setValue($currentWeek === 53 ? 1 : $currentWeek);
            $newWeek->setYear(date("Y"));
            $em->persist($newWeek);
            $em->flush();
        }
        $sql ='
SELECT item.name AS item_name,
item.is_upgrade as item_isUpgrade,
loot.item_upgraded_id AS item_upgraded,
item.id AS item_id,
instance.id AS instance_id, 
player.name AS player_name,
loot.id AS loot_id,
loot.chest,
player_job.id AS playerjob_id,
item.img_url AS item_url, 
week.value AS week,
instance.img_url AS instance_url,
player.img_url AS player_url,
job.img_url AS job_url ,
       job.name AS job_name
FROM instance 
INNER JOIN loot ON instance.id = loot.instance_id 
INNER JOIN player_job ON playerjob_id = player_job.id
INNER JOIN player ON loot.player_id = player.id
INNER JOIN job ON player_job.job_id = job.id
INNER JOIN item ON loot.item_id = item.id 
INNER JOIN week ON loot.week_id = week.id
AND loot.roster_id = :roster AND week.value = :week
';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['week' => $currentWeek, 'roster' => $roster]);
        $result =  $stmt->fetchAll();
        return $this->json($result, 200, []);
    }
    /**
     * @Route("/weeks", name="roster_currentWeek", methods={"GET"})
     */
    public function getWeeksNumber(EntityManagerInterface $em, LootRepository $lootRepository, WeekRepository $weekRepository){
        $roster = $this->getUser();
        $conn = $em->getConnection();
        $currentWeek = date('W');
        $dateCheck = date('D')==='Mon';
        if ($dateCheck){
            $currentWeek -=1;
        }
        $currentWeekId = $weekRepository->findOneBy(['value'=>$currentWeek])->getId();
        $sql = 'SELECT COUNT( DISTINCT week.value) AS weekCount, week.value, week.id, week.year
FROM week INNER JOIN loot ON loot.week_id = week.id
WHERE week.id < :week AND loot.roster_id = :roster
GROUP BY week.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['week' => $currentWeekId, 'roster' => $roster->getId()]);
        $result  =  $stmt->fetchAll();
        $response = new JsonResponse(['weekCount' => $result, 'week'=>$currentWeek, 'showPrevious' => $result? true: false], 200);
        return $response;
    }

    /**
     * @Route("/", name="roster_delete", methods={"DELETE"})
     */
    public function delete(): Response
    {
        $roster = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($roster->getPlayer() as $player){
            $roster->removePlayer($player);
            $entityManager->remove($player);
        }
        $entityManager->remove($roster);
        $entityManager->flush();


        return $this->json('{response : '.$roster->getUsername() . ' has been deleted }', 200);
    }
}
