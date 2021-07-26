<?php

namespace App\Repository;

use App\Entity\Donation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Donation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donation[]    findAll()
 * @method Donation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donation::class);
    }
    public function getData($filter=[])
    {
        return $this->createQueryBuilder('d')
          
            ->orderBy('d.id', 'ASC')
          
            ->getQuery()
         
        ;
    }

    public function getCount($filter=[])
    {
        return $this->createQueryBuilder('d')
          
        ->select("count(d.id)")
            ->orderBy('d.id', 'ASC')
          
            ->getQuery()
            ->getSingleScalarResult()
         
        ;
    }
    public function getSingleData($filter=[])
    {
        return $this->createQueryBuilder('d')
           ->join("d.donor","dn")
           ->join("d.recipient","r")
           ->join("d.donationCenter","dc")
           ->join("d.processedBy","p")
        ->andWhere("dn.id = :donor_id")
        ->setParameter("donor_id",$filter['donor_id'])
           ->select("d.id as donation_id,d.status, dn.id as donor_id,p.id as user_id, r.id as recipient_id, dc.id as donation_center_id")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Donation[] Returns an array of Donation objects
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
    public function findOneBySomeField($value): ?Donation
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
