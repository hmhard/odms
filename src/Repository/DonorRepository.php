<?php

namespace App\Repository;

use App\Entity\Donor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Donor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donor[]    findAll()
 * @method Donor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donor::class);
    }

    // /**
    //  * @return Donor[] Returns an array of Donor objects
    //  */

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
  

    public function getDonorsList($filter = [])
    {
        return $this->createQueryBuilder('d')
            ->join("d.user", "u")
            ->join("d.organ", "o")
            ->join("d.bloodType", "bt")
            ->select("d.id as donor_id, d.status, u.firstName,u.middleName,u.lastName,u.sex,u.phone,u.email,o.name as organ_name, bt.name as bloodType")
            ->getQuery()
            ->getArrayResult();
    }

  
    public function getSingleData($filter=[])
    {
        return $this->createQueryBuilder('d')
           ->join("d.user","u")
           ->join("d.organ","o")
           ->join("d.bloodType","bt")
        //    ->join("r.bloodType","bt")
        ->andWhere("d.id = :id")
        ->setParameter("id",$filter['id'])
           ->select("d.id as donor_id,d.status,  u.id as user_id, u.firstName,u.middleName,u.lastName,u.sex,u.phone,u.email,o.name as organ_name, bt.name as bloodType")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

  
}
