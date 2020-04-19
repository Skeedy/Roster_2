<?php

namespace App\Controller;

use App\Entity\Roster;
use App\Form\RosterType;
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
        $respond = $this->json($rosters, 200, [], ['groups'=> 'test']);
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
                $response = JsonResponse::fromJsonString('{ "response": "This email is already used" }', 404);
                return $response;
            }
            if ($rosterRepository->findOneBy(['rostername'=> $newName])){
                $response = JsonResponse::fromJsonString('{ "response": "This name is already used" }', 404);
                return $response;
            }
        $roster->setRoles(['ROLE_USER']);
        $rawPassword = $roster->getPassword();
        $encode = $encoder->encodePassword($roster, $rawPassword);
        $roster->setPassword($encode);
        $em->persist($roster);
        $em->flush();
        $respond = $this->json($roster, 200, [], ['groups'=> 'test']);
        return $respond;
    }

    /**
     * @Route("/{id}", name="roster_show", methods={"GET"})
     */
    public function show(Roster $roster, SerializerInterface $serializer): Response
    {
        $respond = $this->json($roster, 200, [], ['groups'=> 'test']);
        return $respond;
    }

    /**
     * @Route("/{id}/edit", name="roster_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Roster $roster): Response
    {
        $form = $this->createForm(RosterType::class, $roster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('roster_index');
        }

        return $this->render('roster/edit.html.twig', [
            'roster' => $roster,
            'form' => $form->createView(),
        ]);
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
