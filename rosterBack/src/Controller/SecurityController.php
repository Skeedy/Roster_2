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

//define('url', 'http://90.120.9.48:8080/' );
define('url', 'http://localhost:4200/' );

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
        if($roster) {
            $roster->setIsVerified(true);
            $em->persist($roster);
            $em->flush();
            return $this->redirect(url);
        }
    }
    /**
     * @Route("/checkEmailPassword", name="app_email_password", methods={"POST"})
     */
    public function checkEmail(Request $request,EntityManagerInterface $em, MailerInterface $mailer, SerializerInterface $serializer,RosterRepository $rosterRepository){
        $json = $serializer->decode($request->getContent(), 'json');
        $roster = $rosterRepository->findOneBy(['email'=>$json['email']]); //recherche si l'email existe
        // si existe
        if($roster){
            $roster->setTokenPassword($this->generateToken()); // passe la boolean a true pour la demande de changement de mot de passe
            $em->persist($roster);
            $em->flush();
            $email = (new TemplatedEmail())
                ->from('developper@ffxivroster.com')
                ->to(new Address($json['email']))
                ->subject('FFXIVRoster change password')
                // path of the Twig template to render
                ->htmlTemplate('emails/changePassword.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'roster'=>$roster
                    ]);
            $mailer->send($email);
            return $this->json('An email has been sent, please check it to change your password', 200);
        }
        // si existe pas
        else{
            return $this->json('this email does not exist', 401);
        }
    }

    /**
     * @Route("/redirectPassword", name="app_redirect_password", methods={"GET"})
     */
    public function redirectPassword(RosterRepository $rosterRepository){
        $roster = $rosterRepository->findOneBy(['tokenPassword'=> $_GET['token']]);
        if($roster){
            return $this->redirect(url. 'reset-password?token='. $roster->getTokenPassword());
        }
    }
    /**
     * @Route("/changePassword", name="app_change_password", methods={"POST"})
     */
    public function changePassword(RosterRepository $rosterRepository , EntityManagerInterface $em, Request $request,UserPasswordEncoderInterface $encoder, SerializerInterface  $serializer){
        $json =  $serializer->decode($request->getContent(), 'json');
        $roster = $rosterRepository->findOneBy(['tokenPassword'=> $json['token']]);
        // récupère le password du JSON envoyé et l'encode
        $encode = $encoder->encodePassword($roster, $json['password']);
        // si le roster existe et si il a fait la demande de changement de mot de passe
        if ($roster){
            $roster->setPassword($encode);
            // enlève le token
            $roster->setTokenPassword(NULL);
            $em->persist($roster);
            $em->flush();
            return JsonResponse::fromJsonString('{"response" : "Your password has been changed successfuly !"}', 200);
        }
        // si roster existe mais pas de demande
        if ($roster && $roster->getTokenPassword() == NULL){
            return JsonResponse::fromJsonString('{"response" :"This roster did not ask to change password"}', 403);
        }
        else{
            return JsonResponse::fromJsonString("{'Oops ! a problem occurs, please try again'}", 401);
        }
    }
    function generateToken() {
        return md5(uniqid());
    }
    /**
     * @Route("/updateProfile", name="app_update_profile", methods={"PATCH"})
     */
    function updateDatas(EntityManagerInterface $em, Request $request,RosterRepository $rosterRepository, SerializerInterface  $serializer){
        $json = $serializer->decode($request->getContent(), 'json');
        $roster = $this->getUser();
        $newEmail = false;
        $newName = false;
        if (isset($json['email'])){
            if ($rosterRepository->findOneBy(['email'=> $json['email']])) {
                $response = JsonResponse::fromJsonString('{ "id": "1","response": "This email is already used" }', 401);
                return $response;
            }
            else {
                $roster->setEmail( $json['email']);
                $newEmail= true;
            }
        }
        if (isset($json['rostername'])){
            if ($rosterRepository->findOneBy(['rostername'=> $json['rostername']])) {
                $response = JsonResponse::fromJsonString('{ "id": "1","response": "This name is already used" }', 401);
                return $response;
            }
            else {
                $roster->setRostername($json['rostername']);
                $newName = true;
            }
        }

        $em->persist($roster);
        $em->flush();

        if($newEmail && !$newName){
            $response = $this->json('{respone : The email has been changed}', 200);
            return $response;
        }
        if(!$newEmail && $newName){
            $response = $this->json('{respone : The name has been changed}', 200);
            return $response;
        }
        if($newEmail && $newName){
            $response = $this->json('{respone : Your email  and name have been changed}', 200);
            return $response;
        }
    }

}
