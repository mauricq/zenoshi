<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Receip;
use App\Errors\DuplicatedException;
use App\Errors\ElementNotFoundException;
use App\Repository\ReceipRepository;
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
 * Class ReceiptService
 * @package App\Service
 */
class ReceiptService implements IServiceProviderInterface
{
    /**
     * @var ReceipRepository
     */
    private ReceipRepository $repository;
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

//        $metadataAwareNameConverter = new MetadataAwareNameConverter($this->classMetadataFactory); // injection of MetadataAwareNameConverter
//        new ObjectNormalizer($this->classMetadataFactory, $metadataAwareNameConverter)
    }

    /**
     * ReceiptService constructor.
     * @param ReceipRepository $repository
     * @param array $checkDuplicated
     * @param PrepareDataUtil $prepareDataUtil
     * @param string $dateTimeFormat
     * @param ServiceProvider $serviceProvider
     */
    public function __construct(ReceipRepository $repository, array $checkDuplicated, PrepareDataUtil $prepareDataUtil, string $dateTimeFormat, ServiceProvider $serviceProvider)
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
     * @throws ElementNotFoundException
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
            if (empty($oldData)) throw new ElementNotFoundException (Constants::RESULT_MESSAGE_NOT_FOUND);
            $object->setIdReward($oldData->getIdReceip());
        } else {
            $object->setDateRegistration(date_create());
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
     * @return Receip
     */
    public function filter(array $value): Receip
    {
        return $this->repository->findOneBy($value);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return Receip::class;
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
            "person_upload_receip" => ["id_person_upload_receip", "idPersonUploadReceip", "Person", "idPerson", "id_person"],
            "merchant" => ["id_merchant", "idMerchant", "Merchant", "idMerchant", "id_merchant"],
            "receip_approbation" => ["id_receip_approbation", "idReceipApprobation", "File", "idFile", "file_location"]
        ];
    }
}