<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Catalogue;
use App\Entity\Merchant;
use App\Errors\DuplicatedException;
use App\Repository\CatalogueRepository;
use App\Service\Share\IServiceProviderInterface;
use App\Service\Share\ServiceProvider;
use App\Utils\PrepareDataUtil;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\ORMException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CatalogueService
 * @package App\Service
 */
class CatalogueService implements IServiceProviderInterface
{
    /**
     * @var CatalogueRepository
     */
    private CatalogueRepository $repository;
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
     * @throws AnnotationException
     */
    public function setClassMetadataFactory()
    {
        $this->classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $this->normalizer = new ObjectNormalizer($this->classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $this->serializer = new Serializer([$this->normalizer, new DateTimeNormalizer('Y/m')]);
    }

    /**
     * CatalogueService constructor.
     * @param CatalogueRepository $repository
     * @param PrepareDataUtil $prepareDataUtil
     * @param array $checkDuplicated
     * @param string $dateTimeFormat
     * @param ServiceProvider $serviceProvider
     */
    public function __construct(CatalogueRepository $repository,
                                PrepareDataUtil $prepareDataUtil,
                                array $checkDuplicated,
                                string $dateTimeFormat,
                                ServiceProvider $serviceProvider)
    {
        $this->repository = $repository;
        $this->prepareDataUtil = $prepareDataUtil;
        $this->fieldsCheckDuplicated = $checkDuplicated[strtolower($this->getClassOnly())];
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
     * @return Merchant|bool|null
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
            $object->setIdCatalog($id);
        }

        $this->repository->merge($object);

        $data = $update ? $object : $this->repository->findOneBy($this->criteriaFields);

        $class = strtolower($this->getClassOnly());
        $groups[] = $class;
        if ($update) $groups[] = $class."Uploaded";

        return $this->serializer->normalize($data, null, ['groups' => $groups]);
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
     * @param string $value
     * @param bool $logic
     * @throws ORMException
     */
    public function deleteLogic(string $value, bool $logic = false): void
    {
        if ($logic)
        {
            $update = $this->repository->find($value);
            $update->setStatus("I");
            $this->repository->merge($update);
        } else {
            $this->repository->removeById($this->getClass(), $value);
        }
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
        return Catalogue::class;
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
     */
    public function filterOneBy(array $value): array
    {
        return [$this->repository->findOneBy($value)];
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
        $value = $criteria['value'];
        $criteria = ["type" => $value, "status" => ["A", "P", "R"]];
        $orderBy = empty($orderBy) ? null : ['name' => 'ASC'];

        $result = $this->repository->findBy($criteria, $orderBy, $limit, $offset);
        $data = $this->prepareDataUtil->deleteParentCatalog($value, $result);
        $data = $this->prepareDataUtil->deleteParamsFromCatalog($this->getIds(), $data);

        return $data;
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
            "parent" => ["id_parent", "idParent", "Catalogue", "idCatalog", "id_catalog"]
        ];
    }
}