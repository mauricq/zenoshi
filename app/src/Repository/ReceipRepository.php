<?php

namespace App\Repository;

use App\Entity\Receip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Receip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Receip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Receip[]    findAll()
 * @method Receip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Receip::class);
    }

    // /**
    //  * @return Receip[] Returns an array of Receip objects
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
    public function findOneBySomeField($value): ?Receip
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
