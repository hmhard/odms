<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
  
    public function getData($filter=[])
    {
        return $this->createQueryBuilder('u')
          
            ->orderBy('u.id', 'ASC')
          
            ->getQuery()
         
        ;
    }
  
    public function findForUserGroup($usergroup = null)
    {
        $qb = $this->createQueryBuilder('u');
        if (sizeof($usergroup)>0) {

            $qb->andWhere('u.id not in ( :usergroup )')
                ->setParameter('usergroup', $usergroup);
        }
        // $qb->andWhere("u.roles  like '%ADMIN%' ");



        return $qb->orderBy('u.id', 'ASC')
            ->getQuery()->getResult();
    }
    public function getSingleData($filter=[])
    {
        return $this->createQueryBuilder('u')
        ->andWhere("u.id = :id")
        ->setParameter("id",$filter['id'])
        ->select("u.firstName,u.middleName,u.lastName,u.sex,u.phone,u.email")
        ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
