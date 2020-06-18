<?php


namespace App\Security;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthUserProvider implements UserProviderInterface
{

    /**
     * @required
     * @var UserRepository
     */
    private UserRepository $userManager;

    public function __construct(UserRepository $userManager)
    {
        $this->userManager = $userManager;
    }

    public function loadUserByUsername($username)
    {
        $foundedUser = null;
        try {
            $foundedUser = $this->userManager->loadUserByUsername($username);
        } catch (NonUniqueResultException $e) {
        }

        if ($foundedUser === null) {
            throw new UsernameNotFoundException();
        }

        return $foundedUser;
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}