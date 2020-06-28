<?php

namespace App\Repository;

use App\Entity\Constants;
use App\Entity\Reward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reward|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reward|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reward[]    findAll()
 * @method Reward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardRepository extends ServiceEntityRepository
{
    use RepositoryTrait;


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reward::class);
    }

    public function filterByForeignField(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $field = array_key_first($criteria);
        $val = explode(Constants::FILTER_SEPARATOR, reset($criteria));
        $filter = $val[Constants::FILTER_POSITION_FILTER];
        $value = $val[Constants::FILTER_POSITION_VALUE];

        return $this->createQueryBuilder('r')
//            ->join('r.' . $field, 'm', Join::WITH, 'r.idMerchant = m.idMerchant')
            ->join('r.' . $field, 'm')
            ->andwhere('m.' . $filter . ' = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Reward[] Returns an array of Reward objects
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
    public function findOneBySomeField($value): ?Reward
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
