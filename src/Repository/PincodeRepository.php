<?php

namespace App\Repository;

use App\Entity\Pincode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pincode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pincode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pincode[]    findAll()
 * @method Pincode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PincodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pincode::class);
    }

    // /**
    //  * @return Pincode[] Returns an array of Pincode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pincode
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
