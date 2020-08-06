<?php

namespace App\Repository;

use App\Entity\Oldstuff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Oldstuff|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oldstuff|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oldstuff[]    findAll()
 * @method Oldstuff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OldstuffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oldstuff::class);
    }

    // /**
    //  * @return Oldstuff[] Returns an array of Oldstuff objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Oldstuff
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
