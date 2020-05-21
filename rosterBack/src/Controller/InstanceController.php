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
    /**
     * @Route("/updatepool", name="instancepoolupdate_index", methods={"POST"})
     */
    public function updateItemPool(EntityManagerInterface $em, InstanceRepository $instanceRepository, ItemRepository $itemRepository){
        $instances = $instanceRepository->findAll();
        foreach ($instances as $instance){
            if($instance->getValue() == 1){
                $items = $itemRepository->findBy(['slot' => [6,9,10,11,12], 'ilvl'=> 500, 'isSavage'=>true]);
                foreach ($items as $item) {
                    $instance->addItem($item);
                }
                $em->persist($instance);
                $em->flush();

            }
            if($instance->getValue() == 2){
                $items = $itemRepository->findBy(['slot' => [5,3,8], 'ilvl'=> 500, 'isSavage'=>true]);
                foreach ($items as $item) {
                    $instance->addItem($item);
                }
                $em->persist($instance);
                $em->flush();

            }
            if($instance->getValue() == 3){
                $items = $itemRepository->findBy(['slot' => [5,3,8,7], 'ilvl'=> 500, 'isSavage'=>true]);
                foreach ($items as $item) {
                    $instance->addItem($item);
                }
                $em->persist($instance);
                $em->flush();

            }
            if($instance->getValue() == 4){
                $items = $itemRepository->findBy(['slot' => [1,4], 'ilvl'=> 500, 'isSavage'=>true]);
                foreach ($items as $item) {
                    $instance->addItem($item);
                }
                $em->persist($instance);
                $em->flush();

            }
        }
        $respond = $this->json($instance, 200, [], ['groups' => 'instance']);
        return $respond;
    }

}
