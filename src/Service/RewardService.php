<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Reward;
use App\Errors\DuplicatedException;
use App\Repository\RewardRepository;
use App\Service\Share\IServiceProviderInterface;
use App\Service\Share\ServiceProvider;
use App\Utils\PrepareDataUtil;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\ORMException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class RewardService
 * @package App\Service
 */
class RewardService implements IServiceProviderInterface
{
    /**
     * @var RewardRepository
     */
    private RewardRepository $repository;
    /**
     * @var array
     */
    private array $fieldsCheckDuplicated;
    /**
     * @var array
     */
    private array $criteriaFields = [];
    /**
     * @var PrepareDataUtil
     */
    private PrepareDataUtil $prepareDataUtil;
    /**
     * @var string
     */
    private string $dateTimeFormat;
    /**
     * @var ServiceProvider
     */
    private ServiceProvider $serviceProvider;
    /**
     * @var ClassMetadataFactory
     */
    private ClassMetadataFactory $classMetadataFactory;
    /**
     * @var ObjectNormalizer
     */
    private ObjectNormalizer $normalizer;
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @required
     * @param string $dateTimeFormat
     * @throws AnnotationException
     */
    public function setClassMetadataFactory(string $dateTimeFormat)
    {
        $this->classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $this->normalizer = new ObjectNormalizer($this->classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $this->serializer = new Serializer([new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => $dateTimeFormat]), $this->normalizer], [new JsonEncoder()]);
    }

    /**
     * RewardService constructor.
     * @param RewardRepository $repository
     * @param array $checkDuplicated
     * @param PrepareDataUtil $prepareDataUtil
     * @param string $dateTimeFormat
     * @param ServiceProvider $serviceProvider
     */
    public function __construct(RewardRepository $repository, array $checkDuplicated, PrepareDataUtil $prepareDataUtil, string $dateTimeFormat, ServiceProvider $serviceProvider)
    {
        $this->repository = $repository;
        $this->fieldsCheckDuplicated = $checkDuplicated[strtolower($this->getClassOnly())];
        $this->prepareDataUtil = $prepareDataUtil;
        $this->dateTimeFormat = $dateTimeFormat;
        $this->serviceProvider = $serviceProvider;
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
     * @param EntityProvider $object
     * @param string|null $id
     * @return array|null
     * @throws DuplicatedException
     * @throws ExceptionInterface
     */
    public function saveGeneric(EntityProvider $object, string $id = null): ?array
    {
        $update = !empty($id);
        $isDuplicated = $update ? false : $this->isDuplicated($object);
        if ($isDuplicated) {
            throw new DuplicatedException($this->getClassOnly());
        }

        if ($update) {
            $oldData = $this->repository->find($id);
            $object->setIdReward($id);
        }

        $this->repository->merge($object);

        $data = $update ? $object : $this->repository->findOneBy($this->criteriaFields);

        return $this->serializer->normalize($data, null, ['groups' => [strtolower($this->getClassOnly())]]);
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
        return $this->repository->findAll();
    }

    /**
     * @param array $value
     * @return Reward
     */
    public function filter(array $value): Reward
    {
        return $this->repository->findOneBy($value);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return Reward::class;
    }

    /**
     * @return string
     */
    public function getClassOnly(): string
    {
        return str_replace(Constants::PREPARED_DATA_PATH_ENTITY, "", $this->getClass());
    }

    /**
     * @param array $value
     * @return array
     * @throws ExceptionInterface
     */
    public function filterOneBy(array $value): array
    {
        $data = $this->repository->findOneBy($value);
        return $this->serializer->normalize($data, null, ['groups' => [strtolower($this->getClassOnly())]]);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|null
     * @throws ExceptionInterface
     */
    public function filterBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array
    {
        if (str_contains(reset($criteria), Constants::FILTER_SEPARATOR))
            return $this->filterByForeignField($criteria, $orderBy, $limit, $offset);

        $data = $this->repository->findBy($criteria, $orderBy, $limit, $offset);
        return $this->serializer->normalize($data, null, ['groups' => [strtolower($this->getClassOnly())]]);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|null
     * @throws ExceptionInterface
     */
    public function filterByForeignField(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array
    {
        $data = $this->repository->filterByForeignField($criteria, $orderBy, $limit, $offset);
        return $this->serializer->normalize($data, null, ['groups' => [strtolower($this->getClassOnly())]]);
    }

    /**
     * @param EntityProvider $object
     * @return bool
     */
    public function isDuplicated(EntityProvider $object): bool
    {
        $this->criteriaFields = $this->serviceProvider->getCriteriaFields($this->fieldsCheckDuplicated, $object);
        return $this->serviceProvider->isDuplicated($this->fieldsCheckDuplicated, $object, $this->repository);
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        //json_key_input => id_field_db, idField, FK_Entity, FK_idEntity, FK_id_entity
        return [
            "merchant" => ["id_merchant", "idMerchant", "Merchant", "idMerchant", "id_merchant"],
            "person_registration_reward" => ["id_person_registration_reward", "idPersonRegistrationReward", "Person", "idPerson", "id_person"],
            "reward_status" => ["id_reward_status", "idRewardStatus", "Catalogue", "idCatalog", "id_catalog"],
            "file_reward" => ["id_file_reward", "idFileReward", "File", "idFile", "file_location"]
        ];
    }
}