<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{
    use RepositoryTrait;

    /**
     * Custom method to get user name from Database using username or email fields
     * @param string $username
     * @return mixeds
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        $result = $this->createQueryBuilder('u')
            ->join('u.idPerson', 'p', Join::WITH, 'u.idPerson = p.idPerson')
            ->andwhere('u.username = :username OR u.email = :username OR p.mobile = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();

        if (empty($result)){
            $result = new User();
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    /**
     * @inheritDoc
     */
    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}
