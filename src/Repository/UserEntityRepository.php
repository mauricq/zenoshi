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
        WHEN( u.email = :email ) THEN \'email\'
		WHEN( u.username = :username ) THEN \'username\'
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

    /**
     * Custom method to get user name from Database using username or email fields
     * @param array $uniqueIds
     * @return array
     */
    public function searchUniqueIdDuplicated(array $uniqueIds)
    {
        $result = $this->createQueryBuilder('u')
            ->select('
	(CASE 
			WHEN( u.uniqueId = :unique_id_1 ) THEN 0
			WHEN( u.uniqueId = :unique_id_2 ) THEN 1
			WHEN( u.uniqueId = :unique_id_3 ) THEN 2
			WHEN( u.uniqueId = :unique_id_4 ) THEN 3
			WHEN( u.uniqueId = :unique_id_5 ) THEN 4
			ELSE \'\'
		END) as exist')
            ->andwhere('u.uniqueId  in (:unique_id_1, :unique_id_2, :unique_id_3, :unique_id_4, :unique_id_5)')
            ->setParameter('unique_id_1', $uniqueIds[0][1])
            ->setParameter('unique_id_2', $uniqueIds[1][1])
            ->setParameter('unique_id_3', $uniqueIds[2][1])
            ->setParameter('unique_id_4', $uniqueIds[3][1])
            ->setParameter('unique_id_5', $uniqueIds[4][1])
            ->getQuery()
            ->getResult();

        if (empty($result)) return $result;

        foreach ($result as $item) {
            $return[$item['exist']] = $item['exist'];
        }
        return $return;
    }
}
