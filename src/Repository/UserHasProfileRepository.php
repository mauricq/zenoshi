<?php

namespace App\Repository;

use App\Entity\UserHasProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasProfile[]    findAll()
 * @method UserHasProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasProfile::class);
    }

    // /**
    //  * @return UserHasProfile[] Returns an array of UserHasProfile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserHasProfile
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
