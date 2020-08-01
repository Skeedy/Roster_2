<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\ItemRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/", name="job_index", methods={"GET"})
     */
    public function index(JobRepository $jobRepository ): Response
    {
        $jobs = $jobRepository->findAll();
        $respond = $this->json($jobs, 200, [], ['groups' => 'jobShow']);
        return $respond;
    }
    /**
     * @Route("/{id}", name="job_show", methods={"GET"})
     */
    public function showJobStuff(ItemRepository $itemRepository, Job $job): Response{
        $json = $job->getItems();
        return  $this->json($json, 200, [], ['groups' => 'jobStuff']);
    }
}
