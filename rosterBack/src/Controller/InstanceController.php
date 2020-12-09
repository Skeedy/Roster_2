<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InstanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/instance")
 */
class InstanceController extends AbstractController
{
    /**
     * @Route("/", name="instance_index", methods={"GET"})
     */
    public function index(InstanceRepository $instanceRepository): Response
    {
        $instance = $instanceRepository->findAll();
        $respond = $this->json($instance, 200, [], ['groups' => 'instance']);
        return $respond;
    }

}
