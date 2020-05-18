<?php

namespace App\Controller;

use App\Entity\PlayerJob;
use App\Repository\PlayerJobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/playerjob")
 */
class PlayerjobController extends AbstractController
{
    /**
     * @Route("/", name="playerjob", methods={"GET"})
     */
    public function index(PlayerJobRepository $playerJobRepository)
    {
        $playerjobs = $playerJobRepository->findAll();
        $response = $this->json($playerjobs, 200, [], ['groups'=>'job']);
        return $response;
    }
    /**
     * @Route("/{id}", name="playerjob_delete", methods={"DELETE"})
     */
    public function delete(PlayerJob $playerjob, EntityManagerInterface $em){
        if ($playerjob){
            $em->remove($playerjob);
            $em->flush();
        }
        $response = JsonResponse::fromJsonString('{ "response": "the job has been deleted" }', 200);
        return $response;
    }
}
