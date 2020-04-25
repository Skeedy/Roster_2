<?php
namespace App\Controller;

use App\Entity\Server;
use App\Repository\ServerRepository;
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
 * @Route("/server")
 */
class ServerController extends AbstractController
{
    /**
     * @Route("/", name="server_index", methods={"GET"})
     */
    public function index(ServerRepository $serverRepository): Response
    {
        $server = $serverRepository->findAll();
        $respond = $this->json($server, 200, []);
        return $respond;
    }

}
