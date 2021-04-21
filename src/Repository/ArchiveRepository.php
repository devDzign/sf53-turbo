<?php

namespace App\Repository;

use App\Entity\Archive;
use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @method Archive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archive[]    findAll()
 * @method Archive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveRepository extends ServiceEntityRepository
{
    /**
     *
     */
    private SerializerInterface $serializer;
    private ObjectNormalizer $objectNormalizer;

    public function __construct(
        ManagerRegistry $registry,
        SerializerInterface $serializer,
        ObjectNormalizer $objectNormalizer
    ) {
        parent::__construct($registry, Archive::class);
        $this->serializer = $serializer;
        $this->objectNormalizer = $objectNormalizer;
    }

    /**
     * @return Archive[] Returns an array of Archive objects
     */
    public function findAllArchivesForCompany(string $objectClass, int $objectId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.objectClass = :objectClass')
            ->andWhere('a.objectId = :objectId')
            ->setParameter('objectClass', $objectClass)
            ->setParameter('objectId', $objectId)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }



    /**
     * @return Archive[] Returns an array of Archive objects
     */
    public function findAllArchivesWithDate(string $objectClass, int $objectId, \DateTime $dateTime)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.objectClass = :objectClass')
            ->andWhere('a.objectId = :objectId')
            ->andWhere('a.createdAt >= :date')
            ->setParameter('objectClass', $objectClass)
            ->setParameter('objectId', $objectId)
            ->setParameter('date', $dateTime)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();


        return $qb->getResult();
    }

    /**
     * @return Archive[] Returns an array of Archive objects
     */
    public function findOneArchiveByData(string $objectClass, int $objectId, \DateTime $dateTime)
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.objectClass = :objectClass')
            ->andWhere('a.objectId = :objectId')
            ->andWhere('a.createdAt= :date')
            ->setParameter('objectClass', $objectClass)
            ->setParameter('objectId', $objectId)
            ->setParameter('date', $dateTime)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();


        return $qb->getResult();
    }
}
