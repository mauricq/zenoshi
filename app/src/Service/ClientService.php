<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\EntityProvider;
use App\Repository\ClientRepository;
use App\Service\Share\IServiceProviderInterface;

/**
 * Class ClientService
 * @package App\Service
 */
class ClientService implements IServiceProviderInterface
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * ClientService constructor.
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
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
     * @throws \Doctrine\ORM\ORMException
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
        $this->repository->findOneBy($value);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
//        return get_class($this);
        return Client::class;
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
        // TODO: Implement filterBy() method.
    }
}