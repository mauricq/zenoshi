<?php

namespace App\Repository;

use App\Entity\UserHasProfiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasProfiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasProfiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasProfiles[]    findAll()
 * @method UserHasProfiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasProfilesRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasProfiles::class);
    }

    // /**
    //  * @return UserHasProfiles[] Returns an array of UserHasProfiles objects
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
    public function findOneBySomeField($value): ?UserHasProfiles
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
