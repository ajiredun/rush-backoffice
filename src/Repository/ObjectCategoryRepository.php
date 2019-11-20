<?php

namespace App\Repository;

use App\Entity\ObjectCategory;
use App\Service\SearchParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjectCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectCategory[]    findAll()
 * @method ObjectCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectCategory::class);
    }



    public function getWithSearchQueryBuilder(SearchParams $searchParams)
    {
        $term = $searchParams->getCurrent('name');

        $qb = $this->createQueryBuilder('object_category');

        if (!empty($term)) {
            $qb->orWhere('object_category.name LIKE :term')
                ->setParameter('term', "%$term%");
        }

        return $qb->getQuery();
    }


    // /**
    //  * @return ObjectCategory[] Returns an array of ObjectCategory objects
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
    public function findOneBySomeField($value): ?ObjectCategory
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
