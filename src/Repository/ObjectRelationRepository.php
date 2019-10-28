<?php

namespace App\Repository;

use App\Entity\ObjectRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjectRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectRelation[]    findAll()
 * @method ObjectRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectRelation::class);
    }

    // /**
    //  * @return ObjectRelation[] Returns an array of ObjectRelation objects
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
    public function findOneBySomeField($value): ?ObjectRelation
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
