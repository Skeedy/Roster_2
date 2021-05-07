<?php
namespace App\Controller;

use App\Entity\Roster;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

define('url', 'http://90.120.9.48:8080/roster' );

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/confirmemail/{id}", name="app_confirm_email", methods={"GET"})
     */
    public function comfirmEmail(Roster $roster,  EntityManagerInterface $em){
        $roster->setIsVerified(true);
        $em->persist($roster);
        $em->flush();
        $this->redirect(url);
        return $this->json($roster, 200, [], ['groups'=> 'roster']);
    }
}
