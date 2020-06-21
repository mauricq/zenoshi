<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Person;
use App\Repository\PersonRepository;
use App\Service\Share\IServiceProviderInterface;

/**
 * Class PersonService
 * @package App\Service
 */
class PersonService implements IServiceProviderInterface
{
    /**
     * @var PersonRepository
     */
    private $repository;

    /**
     * PersonService constructor.
     * @param PersonRepository $repository
     */
    public function __construct(PersonRepository $repository)
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
        return $this->repository->findOneBy(["mobile" => $object->getMobile()]);
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
     * @param array $value
     * @return array
     */
    public function filterOneBy(array $value): array
    {
        $this->repository->findOneBy($value);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return Person::class;
    }

    /**
     * @return string
     */
    public function getClassOnly(): string
    {
        return str_replace(Constants::PREPARED_DATA_PATH_ENTITY, "", $this->getClass());
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