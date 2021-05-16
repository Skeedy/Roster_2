<?php
namespace App\Controller;

use App\Entity\Roster;
use App\Repository\RosterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;

define('url', 'http://90.120.9.48:8080/' );

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
        $this->redirect(url. 'roster');
        return $this->json($roster, 200, [], ['groups'=> 'roster']);
    }
    /**
     * @Route("/checkEmailPassword", name="app_email_password", methods={"POST"})
     */
    public function checkEmail(Request $request,EntityManagerInterface $em, MailerInterface $mailer, SerializerInterface $serializer,RosterRepository $rosterRepository){
        $json = $serializer->decode($request->getContent(), 'json');
        $roster = $rosterRepository->findOneBy(['email'=>$json['email']]);

        if($roster){
            /* $email = (new TemplatedEmail())
                ->from('developper@ffxivroster.com')
                ->to(new Address($json['email']))
                ->subject('Welcome to FFXIVRoster!')
                // path of the Twig template to render
                ->htmlTemplate('emails/registration.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'roster'=>$roster
                    ]);
            $mailer->send($email); */
            $roster->setPasswordPending(true);
            $em->persist($roster);
            $em->flush();
            return $this->json('An email has been sent, please check it to change your password', 200);
        }
        else{
            return $this->json('this email does not exist', 401);
        }
    }

    /**
     * @Route("/redirectPassword/{id}", name="app_redirect_password", methods={"GET"})
     */
    public function redirectPassword(Roster $roster){
        if($roster){
            return $this->redirect(url. 'reset-password?id='. $roster->getId().'asked='.$roster->getPasswordPending());
        }
        else{
            return $this->json('prout');
        }
    }
    /**
     * @Route("/changePassword/{id}", name="app_change_password", methods={"POST"})
     */
    public function changePassword(Roster $roster, EntityManagerInterface $em, Request $request,UserPasswordEncoderInterface $encoder, SerializerInterface  $serializer){
        $json =  $serializer->decode($request->getContent(), 'json');
        $encode = $encoder->encodePassword($roster, $json['password']);
        if ($roster && $roster->getPasswordPending()){
            $roster->setPassword($encode);
            $roster->setPasswordPending(false);
            $em->persist($roster);
            $em->flush();
            return JsonResponse::fromJsonString('{"response" : "Your password has been changed successfuly !"}', 200);
        }
        if ($roster && !$roster->getPasswordPending()){
            return JsonResponse::fromJsonString('{"response" :"This roster did not ask to change password"}', 403);
        }
        else{
            return JsonResponse::fromJsonString("{'Oops a problem occurs, please try again'}", 401);
        }
    }
}
