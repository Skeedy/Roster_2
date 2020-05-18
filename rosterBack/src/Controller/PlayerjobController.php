<?php

namespace App\Controller;

use App\Entity\Player;
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
    public function delete(PlayerJob $playerjob, PlayerJobRepository $playerJobRepository, EntityManagerInterface $em){
        if ($playerjob){
            $player = $playerjob->getPlayer();
            $playerjobList = $player->getPlayerJobs();
            $i = 1;
            $em->remove($playerjob);
            $em->flush();
            foreach ($playerjobList as $job){
                $job->setOrd($job->getIsMain() ? 1 : $i);
                $i++;
            }
            $em->persist($job);
            $em->flush();
        }
        $response = JsonResponse::fromJsonString('{ "response": "the job has been deleted" }', 200);
        return $response;
    }
}
