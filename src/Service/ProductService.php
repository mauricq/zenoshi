<?php


namespace App\Service;


use App\Entity\EntityProvider;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Share\IServiceProviderInterface;

/**
 * Class ProductService
 * @package App\Service
 */
class ProductService implements IServiceProviderInterface
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductService constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EntityProvider $object
     * @return EntityProvider|null
     */
    public function save(EntityProvider $object): ?EntityProvider
    {
        $this->repository->merge($object);
        return $this->repository->findOneBy(["type" => $object->getType(), "name" => $object->getName()]);
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
        return $this->repository->findAll();
    }

    /**
     * @param string $value
     * @return array
     */
    public function filter(string $value = ''): array
    {
        return $this->repository->findOneBy($value);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return Product::class;
    }

    /**
     * @param array $value
     * @return array
     */
    public function filterOneBy(array $value): array
    {
        return $this->repository->findOneBy($value);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|null
     */
    public function filterBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }
}