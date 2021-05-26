<?php

namespace App\Repository\Admin;

use App\Entity\Admin\PolitiquePub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PolitiquePub|null find($id, $lockMode = null, $lockVersion = null)
 * @method PolitiquePub|null findOneBy(array $criteria, array $orderBy = null)
 * @method PolitiquePub[]    findAll()
 * @method PolitiquePub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolitiquePubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PolitiquePub::class);
    }

    // /**
    //  * @return PolitiquePub[] Returns an array of PolitiquePub objects
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
    public function findOneBySomeField($value): ?PolitiquePub
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
