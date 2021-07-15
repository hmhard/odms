<?php

namespace App\Repository;

use App\Entity\AppointmentConversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppointmentConversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppointmentConversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppointmentConversation[]    findAll()
 * @method AppointmentConversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppointmentConversation::class);
    }

    // /**
    //  * @return AppointmentConversation[] Returns an array of AppointmentConversation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppointmentConversation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
