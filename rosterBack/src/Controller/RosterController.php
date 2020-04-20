<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Roster;
use App\Repository\PlayerRepository;
use App\Repository\RosterRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/roster")
 */
class RosterController extends AbstractController
{
    /**
     * @Route("/", name="roster_index", methods={"GET"})
     */
    public function index(RosterRepository $rosterRepository ): Response
    {
        $rosters = $rosterRepository->findAll();
        $respond = $this->json($rosters, 200, [], ['groups'=> 'roster']);
        return $respond;
    }

    /**
     * @Route("/new", name="roster_new", methods={"POST"})
     */
    public function new(Request $request,RosterRepository $rosterRepository, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
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
        $roster->setPassword($encode);
        $em->persist($roster);
        $em->flush();
        $respond = $this->json($roster, 200, [], ['groups'=> 'roster']);
        return $respond;
    }

    /**
     * @Route("/{id}", name="roster_show", methods={"GET"})
     */
    public function show(Roster $roster): Response
    {
        $respond = $this->json($roster, 200, [], ['groups'=> 'roster']);
        return $respond;
    }

    /**
     * @Route("/patch/{id}", name="roster_patch", methods={"PATCH"})
     */
    public function patch(Request $request, SerializerInterface $serializer,PlayerRepository $playerRepository,Roster $roster, EntityManagerInterface $em){
        $jsonPost = $request->getContent();
        $json = $serializer->decode($jsonPost, 'json');
        $playerIds = $json['playersId'];
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
