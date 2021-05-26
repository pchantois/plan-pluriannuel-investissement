<?php

namespace App\Repository\Admin;

use App\Entity\Admin\CodeMaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CodeMaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodeMaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodeMaire[]    findAll()
 * @method CodeMaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeMaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodeMaire::class);
    }

    // /**
    //  * @return CodeMaire[] Returns an array of CodeMaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CodeMaire
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
