<?php

namespace App\Repository;

use App\Entity\AdminOperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdminOperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminOperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminOperation[]    findAll()
 * @method AdminOperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminOperation::class);
    }

    // /**
    //  * @return AdminOperation[] Returns an array of AdminOperation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminOperation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
