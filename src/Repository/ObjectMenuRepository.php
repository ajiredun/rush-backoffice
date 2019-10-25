<?php

namespace App\Repository;

use App\Entity\ObjectMenu;
use App\Service\SearchParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjectMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectMenu[]    findAll()
 * @method ObjectMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectMenu::class);
    }


    public function getWithSearchQueryBuilder(SearchParams $searchParams)
    {
        $term = $searchParams->getCurrent('name');

        $qb = $this->createQueryBuilder('object_menu');

        if (!empty($term)) {
            $qb->orWhere('object_menu.name LIKE :term')
                ->setParameter('term', "%$term%");
        }

        return $qb->getQuery();
    }


    // /**
    //  * @return ObjectMenu[] Returns an array of ObjectMenu objects
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
    public function findOneBySomeField($value): ?ObjectMenu
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
