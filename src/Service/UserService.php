<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\Merchant;
use App\Entity\User;
use App\Entity\EntityProvider;
use App\Repository\mixeds;
use App\Repository\UserEntityRepository;
use App\Service\Share\IServiceProviderInterface;
use Doctrine\ORM\ORMException;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;

/**
 * Class UserService
 * @package App\Service
 */
class UserService implements IServiceProviderInterface
{
    /**
     * @var ArrayTransformerInterface
     */
    protected ArrayTransformerInterface $arrayTransformer;
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;
    /**
     * @var UserEntityRepository
     */
    private UserEntityRepository $repository;

    /**
     * UserService constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param UserEntityRepository $repository
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer, SerializerInterface $serializer, UserEntityRepository $repository)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
        $this->repository = $repository;
    }
    /**
     * UserService constructor.
     * @param UserEntityRepository $repository
     */


    /**
     * @param EntityProvider $object
     * @return EntityProvider|null
     */
    public function save(EntityProvider $object): ?EntityProvider
    {
        return $this->repository->merge($object);
    }

    /**
     * @param EntityProvider $object
     * @param string|null $id
     * @return Merchant|bool|null
     */
    public function saveGeneric(EntityProvider $object, string $id = null): ?array
    {
        return null;
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
     * @param array $value
     * @return array
     */
    public function filterOneBy(array $value): array
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

    /**
     * @param string $username
     * @param string $email
     * @param string $mobile
     * @return mixeds
     */
    public function searchDuplicated(string $username, string $email, string $mobile)
    {
        return $this->repository->searchDuplicated($username, $email, $mobile);
    }

    public function prepareResponseData(User $object): array
    {
        return $this->arrayTransformer->toArray($object);
    }
}