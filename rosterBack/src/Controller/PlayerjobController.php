<?php

namespace App\Controller;

use App\Repository\PlayerJobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayerjobController extends AbstractController
{
    /**
     * @Route("/playerjob", name="playerjob", methods={"GET"})
     */
    public function index(PlayerJobRepository $playerJobRepository)
    {
        $playerjobs = $playerJobRepository->findAll();
        $response = $this->json($playerjobs, 200, [], ['groups'=>'job']);
        return $response;
    }
}
