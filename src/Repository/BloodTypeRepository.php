<?php

namespace App\Repository;

use App\Entity\BloodType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BloodType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BloodType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BloodType[]    findAll()
 * @method BloodType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BloodTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BloodType::class);
    }
    public function getBloodList($filter = [])
    {
        return $this->createQueryBuilder('b')
            
            ->select("b.id, b.name")
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return BloodType[] Returns an array of BloodType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BloodType
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
