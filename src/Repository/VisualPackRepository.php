<?php

namespace App\Repository;

use App\Entity\VisualPack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VisualPack|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualPack|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualPack[]    findAll()
 * @method VisualPack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualPackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualPack::class);
    }

    // /**
    //  * @return VisualPack[] Returns an array of VisualPack objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VisualPack
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
