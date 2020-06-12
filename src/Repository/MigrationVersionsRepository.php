<?php

namespace App\Repository;

use App\Entity\MigrationVersions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MigrationVersions|null find($id, $lockMode = null, $lockVersion = null)
 * @method MigrationVersions|null findOneBy(array $criteria, array $orderBy = null)
 * @method MigrationVersions[]    findAll()
 * @method MigrationVersions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MigrationVersionsRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MigrationVersions::class);
    }

    // /**
    //  * @return MigrationVersions[] Returns an array of MigrationVersions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MigrationVersions
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
