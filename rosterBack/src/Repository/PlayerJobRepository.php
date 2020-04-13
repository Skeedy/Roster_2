<?php

namespace App\Repository;

use App\Entity\PlayerJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayerJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerJob[]    findAll()
 * @method PlayerJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerJob::class);
    }

    // /**
    //  * @return PlayerJob[] Returns an array of PlayerJob objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayerJob
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
