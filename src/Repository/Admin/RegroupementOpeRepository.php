<?php

namespace App\Repository\Admin;

use App\Entity\Admin\RegroupementOpe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * @method RegroupementOpe|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegroupementOpe|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegroupementOpe[]    findAll()
 * @method RegroupementOpe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegroupementOpeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegroupementOpe::class);
    }

    // /**
    //  * @return RegroupementOpe[] Returns an array of RegroupementOpe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegroupementOpe
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
