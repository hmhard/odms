<?php

namespace App\Repository;

use App\Entity\RecipientStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipientStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipientStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipientStatus[]    findAll()
 * @method RecipientStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipientStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipientStatus::class);
    }

    // /**
    //  * @return RecipientStatus[] Returns an array of RecipientStatus objects
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
    public function findOneBySomeField($value): ?RecipientStatus
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
