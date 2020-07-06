<?php

namespace App\Repository;

use App\Entity\WishItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WishItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishItem[]    findAll()
 * @method WishItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishItem::class);
    }

    // /**
    //  * @return WishItem[] Returns an array of WishItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WishItem
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
