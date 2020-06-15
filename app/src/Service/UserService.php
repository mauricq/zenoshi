<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\EntityProvider;
use App\Repository\UserEntityRepository;
use App\Service\Share\IServiceProviderInterface;
use Doctrine\ORM\ORMException;

/**
 * Class UserService
 * @package App\Service
 */
class UserService implements IServiceProviderInterface
{
    /**
     * @var UserEntityRepository
     */
    private $repository;

    /**
     * UserService constructor.
     * @param UserEntityRepository $repository
     */
    public function __construct(UserEntityRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param EntityProvider $object
     * @return EntityProvider|null
     */
    public function save(EntityProvider $object): ?EntityProvider
    {
        return $this->repository->merge($object);
    }

    /**
     * @param string $value
     * @throws ORMException
     */
    public function delete(string $value): void
    {
        $this->repository->removeById($this->getClass(), $value);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $this->repository->findAll();
    }

    /**
     * @param string $value
     * @return array
     */
    public function filterOneBy(string $value = ''): array
    {
        $this->repository->findOneBy([$value]);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return User::class;
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function filterBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }
}