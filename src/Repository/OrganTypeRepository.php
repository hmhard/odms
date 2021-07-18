<?php

namespace App\Repository;

use App\Entity\OrganType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrganType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganType[]    findAll()
 * @method OrganType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganType::class);
    }
    public function getOrganList($filter = [])
    {
        return $this->createQueryBuilder('b')
            
            ->select("b.id, b.name")
            ->getQuery()
            ->getArrayResult();
    }
    // /**
    //  * @return OrganType[] Returns an array of OrganType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrganType
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
