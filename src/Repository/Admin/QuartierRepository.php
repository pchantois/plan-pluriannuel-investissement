<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Quartier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Quartier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quartier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quartier[]    findAll()
 * @method Quartier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuartierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quartier::class);
    }

    // /**
    //  * @return Quartier[] Returns an array of Quartier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quartier
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
