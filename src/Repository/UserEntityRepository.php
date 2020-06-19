<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return Person[] Returns an array of Person objects
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
    public function findOneBySomeField($value): ?Person
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * Custom method to get user name from Database using username or email fields
     * @param string $username
     * @param string $email
     * @param string $mobile |null
     * @return mixeds
     */
    public function searchDuplicated(string $username, string $email, ?string $mobile = "")
    {
        $result = $this->createQueryBuilder('u')
            ->select('
	(CASE 
		WHEN( u.username = :username ) THEN \'username\'
        WHEN( u.email = :email ) THEN \'email\'
        WHEN( p.mobile = :mobile ) THEN \'mobile\'
		ELSE \'\'
	END) as duplicated')
            ->join('u.idPerson', 'p', Join::WITH, 'u.idPerson = p.idPerson')
            ->andwhere('u.username = :username OR u.email = :email OR p.mobile = :mobile')
            ->setParameter('username', $username)
            ->setParameter('email', $email)
            ->setParameter('mobile', $mobile)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
