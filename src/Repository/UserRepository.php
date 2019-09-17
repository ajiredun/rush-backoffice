<?php

namespace App\Repository;

use App\Entity\User;
use App\Enums\UserStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function findOnlineUsers($lazy = false)
    {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.lastactive > :date')
            ->setParameter('date', new \DateTime('5 minutes ago'));
        if ($lazy) {
            $qb->select('u.id');
        }
        $qb = $qb->getQuery();

        return $qb->execute();
    }

    public function findTotalActiveUsers($lazy = false)
    {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.status != :status')
            ->setParameter('status', UserStatus::ARCHIVED);

        if ($lazy) {
            $qb->select('u.id');
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    public function findUsersCreatedByMonth($delay = null, $lazy = false)
    {
        // if you want for a month specific '-1 month'

        $start = new \DateTime('first day of this month');
        $end = new \DateTime('last day of this month');

        if ($delay !== null) {
            $start->modify($delay);
            $end->modify($delay);
            $end->modify('last day of this month');
        }

        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.createdAt >= :date')
            ->andWhere('u.createdAt < :dateEnd')
            ->setParameter('date',$start)
            ->setParameter('dateEnd',$end)
            ->andWhere('u.status != :status')
            ->setParameter('status', UserStatus::ARCHIVED);

        if ($lazy) {
            $qb->select('u.id');
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
