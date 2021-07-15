<?php

namespace App\Repository;

use App\Entity\Recipient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recipient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipient[]    findAll()
 * @method Recipient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipient::class);
    }


    public function getData($filter=[])
    {
        return $this->createQueryBuilder('r')
          
            ->orderBy('r.id', 'ASC')
          
            ->getQuery()
         
        ;
    }
    public function getCount($filter=[])
    {
        return $this->createQueryBuilder('r')
          
        ->select("count(r.id)")
            ->orderBy('r.id', 'ASC')
          
            ->getQuery()
            ->getSingleScalarResult()
         
        ;
    }
  
  

    public function getRecipientList($filter=[])
    {
        return $this->createQueryBuilder('r')
           ->join("r.user","u")
           ->join("r.organNeeded","o")
           ->select("u.firstName,u.middleName,u.lastName,u.sex,u.phone,u.email,o.name as organ_name")
            ->getQuery()
            ->getArrayResult()
        ;
    }
  

    // /**
    //  * @return Recipient[] Returns an array of Recipient objects
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
    public function findOneBySomeField($value): ?Recipient
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
