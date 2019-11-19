<?php

namespace App\Repository;

use App\Entity\ObjectProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjectProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectProduct[]    findAll()
 * @method ObjectProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectProduct::class);
    }

    // /**
    //  * @return ObjectProduct[] Returns an array of ObjectProduct objects
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
    public function findOneBySomeField($value): ?ObjectProduct
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
