<?php

namespace App\Repository\Objet;

use App\Entity\Objet\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Menu::class);
	}

	// /**
	//  * @return Menu[] Returns an array of Menu objects
	//  */
	public function findMainMenu($reference) {
		return $this->createQueryBuilder('m')
			->andWhere('m.categorie = :categorie')
			->setParameter('categorie', 'main')
			->andWhere('m.ref = :reference')
			->setParameter('reference', $reference)
			->orderBy('m.rang', 'ASC')
			->getQuery()
			->getResult()
		;
	}

	/*
		    public function findOneBySomeField($value): ?Menu
		    {
		        return $this->createQueryBuilder('m')
		            ->andWhere('m.exampleField = :val')
		            ->setParameter('val', $value)
		            ->getQuery()
		            ->getOneOrNullResult()
		        ;
		    }
	*/
}
