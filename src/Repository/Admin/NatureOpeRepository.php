<?php

namespace App\Repository\Admin;

use App\Entity\Admin\NatureOpe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * @method NatureOpe|null find($id, $lockMode = null, $lockVersion = null)
 * @method NatureOpe|null findOneBy(array $criteria, array $orderBy = null)
 * @method NatureOpe[]    findAll()
 * @method NatureOpe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NatureOpeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NatureOpe::class);
    }

    // /**
    //  * @return NatureOpe[] Returns an array of NatureOpe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NatureOpe
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
