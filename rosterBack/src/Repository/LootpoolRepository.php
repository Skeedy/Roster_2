<?php

namespace App\Repository;

use App\Entity\Lootpool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lootpool|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lootpool|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lootpool[]    findAll()
 * @method Lootpool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LootpoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lootpool::class);
    }

    // /**
    //  * @return Lootpool[] Returns an array of Lootpool objects
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
    public function findOneBySomeField($value): ?Lootpool
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
