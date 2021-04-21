<?php

namespace App\Repository;

use App\Entity\LegalCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalCategories[]    findAll()
 * @method LegalCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalCategories::class);
    }

    // /**
    //  * @return LegalCategories[] Returns an array of LegalCategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LegalCategories
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
