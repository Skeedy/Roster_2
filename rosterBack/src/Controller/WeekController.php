<?php


namespace App\Controller;

use App\Entity\Week;
use App\Repository\WeekRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/week")
 */
class WeekController extends AbstractController
{
    /**
     * @Route ("/", name="week", methods={"GET"})
     */
    public function getWeek(WeekRepository $weekRepository){
        $week = $weekRepository->findOneBy(['weekNumber' => date('W')]);
//        $loots = $week->getLoots();
        return $this->json($week, 200,[], ['groups'=>'loots']);
    }

}
