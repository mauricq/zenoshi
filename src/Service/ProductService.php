<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Merchant;
use App\Entity\Product;
use App\Errors\DuplicatedException;
use App\Repository\ProductRepository;
use App\Service\Share\IServiceProviderInterface;
use App\Service\Share\ServiceProvider;
use App\Utils\PrepareDataUtil;

/**
 * Class ProductService
 * @package App\Service
 */
class ProductService implements IServiceProviderInterface
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $repository;
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
     * ProductService constructor.
     * @param ProductRepository $repository
     * @param array $checkDuplicated
     * @param PrepareDataUtil $prepareDataUtil
     * @param string $dateTimeFormat
     * @param ServiceProvider $serviceProvider
     */
    public function __construct(ProductRepository $repository, array $checkDuplicated, PrepareDataUtil $prepareDataUtil, string $dateTimeFormat, ServiceProvider $serviceProvider)
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
     * @return Merchant|bool|null
     * @throws DuplicatedException
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
            $object->setIdProduct($id);
        }

        $this->repository->merge($object);

        $data = $update ? $object : $this->repository->findOneBy($this->criteriaFields);
        $data = $this->prepareDataUtil->deleteParamsFromCatalog($this->getIds(), [$data]);

        return $data;
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
        $result = $this->repository->findBy($criteria, $orderBy, $limit, $offset);
        return $this->prepareDataUtil->deleteParamsFromCatalog($this->getIds(), $result);
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
            "product_status" => ["id_product_status", "idProductStatus", "Catalogue", "idCatalog", "id_catalog"],
            "photo_product" => ["id_photo_product", "idPhotoProduct", "File", "idFile", "id_file"]
        ];
    }
}