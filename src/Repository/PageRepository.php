<?php

namespace App\Repository;

use App\Entity\Page;
use App\Enums\UserStatus;
use App\Service\SearchParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findPagesCreatedByMonth($delay = null, $lazy = false)
    {
        // if you want for a month specific '-1 month'

        $start = new \DateTime('first day of this month');
        $end = new \DateTime('last day of this month');

        if ($delay !== null) {
            $start->modify($delay);
            $end->modify($delay);
            $end->modify('last day of this month');
        }

        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :date')
            ->andWhere('p.createdAt < :dateEnd')
            ->setParameter('date', $start)
            ->setParameter('dateEnd', $end)
            ->andWhere('p.published = :published')
            ->setParameter('published', true);

        if ($lazy) {
            $qb->select('p.id');
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }


    public function getWithSearchQueryBuilder(SearchParams $searchParams)
    {
        $term = $searchParams->getCurrent('name');
        $role = $searchParams->getCurrent('role');
        $status = $searchParams->getCurrent('status');

        $qb = $this->createQueryBuilder('p');

        if (!empty($term)) {
            $qb->orWhere('p.name LIKE :term')
                ->setParameter('term', "%$term%");
            $qb->orWhere('p.route LIKE :term')
                ->setParameter('term', "$term%");
            $qb->orWhere('p.seoTitle LIKE :term')
                ->setParameter('term', "%$term%");
        }

        if (!empty($status)) {
            if ($status === 'PUBLISHED') {
                $status = true;
            }

            if ($status === 'DRAFT') {
                $status = false;
            }

            $qb->andWhere($qb->expr()->eq('p.published', ':status'))
                ->setParameter('status', $status);
        }

        if (!empty($role)) {
            $qb->andWhere("p.roles LIKE :role")
                ->setParameter('role', '%"' . $role . '"%');
        }

        $qb->orderBy('p.route', "ASC");



        return $qb->getQuery();
    }

    // /**
    //  * @return Page[] Returns an array of Page objects
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
    public function findOneBySomeField($value): ?Page
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
