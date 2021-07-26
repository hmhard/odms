<?php

namespace App\Repository;

use App\Entity\DonationCenter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DonationCenter|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonationCenter|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonationCenter[]    findAll()
 * @method DonationCenter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationCenterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonationCenter::class);
    }
    public function getData($filter=[])
    {
        return $this->createQueryBuilder('d')
          
            ->orderBy('d.id', 'ASC')
          
            ->getQuery()
         
        ;
    }


    public function getDonationCenterList($filter=[])
    {
        return $this->createQueryBuilder('d')
      
           ->select("d.id, d.name, d.address, d.location, d.photo , d.description")
            ->getQuery()
            ->getArrayResult()
        ;
    }
    public function getSingleData($filter=[])
    {
        return $this->createQueryBuilder('d')
         
        ->andWhere("d.id = :id")
        ->setParameter("id",$filter['id'])
        ->select("d.id,d.name, d.address, d.location, d.photo , d.description") 
           ->getQuery()
            ->getOneOrNullResult()
        ;
    }
  
  

    // /**
    //  * @return DonationCenter[] Returns an array of DonationCenter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DonationCenter
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
