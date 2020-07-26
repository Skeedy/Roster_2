<?php

namespace App\Repository;

use App\Entity\CurrentStuff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CurrentStuff|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrentStuff|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrentStuff[]    findAll()
 * @method CurrentStuff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrentStuffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrentStuff::class);
    }

    // /**
    //  * @return CurrentStuff[] Returns an array of CurrentStuff objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CurrentStuff
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
