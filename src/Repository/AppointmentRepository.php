<?php

namespace App\Repository;

use App\Entity\Appointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }


    public function getData($filter=[])
    {
        return $this->createQueryBuilder('a')
          
            ->orderBy('a.id', 'ASC')
          
            ->getQuery()
         
        ;
    }
    public function getCount($filter=[])
    {
        return $this->createQueryBuilder('a')
          
        ->select("count(a.id)")
            ->orderBy('a.id', 'ASC')
          
            ->getQuery()
            ->getSingleScalarResult()
         
        ;
    }
    public function getSingleData($filter=[])
    {
        return $this->createQueryBuilder('a')
           ->join("a.appointedBy","ab")
           ->join("a.donor","d")
        ->andWhere("d.id = :id")
        ->setParameter("id",$filter['id'])
           ->select("a.id as appointment_id,d.id as donor_id,a.status, a.appointmentDate, ab.id as user_id, ab.firstName,ab.middleName,ab.lastName")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
  
    // /**
    //  * @return Appointment[] Returns an array of Appointment objects
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
    public function findOneBySomeField($value): ?Appointment
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
