<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Merchant;
use App\Errors\DuplicatedException;
use App\Repository\MerchantRepository;
use App\Service\Share\IServiceProviderInterface;
use App\Utils\PrepareDataUtil;
use Doctrine\ORM\ORMException;
use Exception;

/**
 * Class MerchantService
 * @package App\Service
 */
class MerchantService implements IServiceProviderInterface
{
    /**
     * @var MerchantRepository
     */
    private MerchantRepository $repository;
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
     * MerchantService constructor.
     * @param MerchantRepository $repository
     * @param array $checkDuplicated
     * @param PrepareDataUtil $prepareDataUtil
     * @param string $dateTimeFormat
     */
    public function __construct(MerchantRepository $repository, array $checkDuplicated, PrepareDataUtil $prepareDataUtil, string $dateTimeFormat)
    {
        $this->repository = $repository;
        $this->fieldsCheckDuplicated = $checkDuplicated[strtolower($this->getClassOnly())];
        $this->prepareDataUtil = $prepareDataUtil;
        $this->dateTimeFormat = $dateTimeFormat;
    }

    public function save(EntityProvider $entityProvider): ?EntityProvider
    {
        $this->repository->merge($entityProvider);
    }

    /**
     * @param EntityProvider $object
     * @return Merchant|bool|null
     * @throws Exception
     */
    public function saveV2(EntityProvider $object): ?array
    {
        $isDuplicated = $this->isDuplicated($object);
        if ($isDuplicated) {
            throw new DuplicatedException($this->getClassOnly());
        }

        $object->setRegistrationDate(date_create());
        $this->repository->merge($object);

        $data = $this->repository->findOneBy($this->criteriaFields);
        $data = $this->prepareDataUtil->deleteParamsFromCatalog($this->getIds(), [$data]);

        return $data;
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
     * @return Merchant
     */
    public function filter(array $value): Merchant
    {
        return $this->repository->findOneBy($value);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return Merchant::class;
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
        if (!$this->fieldsCheckDuplicated['enabled']) return false;

        foreach ($this->fieldsCheckDuplicated['fields'] as $field) {
            $getCheckFields = $this->prepareDataUtil->getGetMethodByIdName($field);
            $this->criteriaFields[$field] = $object->$getCheckFields();
        }
        $check = true;
        if (empty($this->repository->findOneBy($this->criteriaFields))) {
            $check = false;
        }
        return $check;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
//        const PREPARED_DATA_JSON_KEY_INPUT = "0";
//        const PREPARED_DATA_ID_FIELD_DB = "0";
//        const PREPARED_DATA_ID_FIELD = "1";
//        const PREPARED_DATA_FK_ENTITY = "2";
//        const PREPARED_DATA_FK_IDENTITY = "3";
//        const PREPARED_DATA_FK_ID_ENTITY = "4";
        //json_key_input => id_field_db, idField, FK_Entity, FK_idEntity, FK_id_entity
        return [
            "merchant_status" => ["id_merchant_status", "idMerchantStatus", "Catalogue", "idCatalog", "id_catalog"],
            "merchant_category" => ["id_merchant_category", "idMerchantCategory", "Catalogue", "idCatalog", "id_catalog"],
            "merchant_status_approval" => ["id_merchant_status_approval", "idMerchantStatusApproval", "Catalogue", "idCatalog", "id_catalog"],
            "person" => ["id_person", "idPerson", "Person", "idPerson", "id_person"]
        ];
    }
}