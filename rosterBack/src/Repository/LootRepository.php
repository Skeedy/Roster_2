<?php

namespace App\Repository;

use App\Entity\Loot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Loot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loot[]    findAll()
 * @method Loot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LootRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loot::class);
    }

    // /**
    //  * @return Loot[] Returns an array of Loot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Loot
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
