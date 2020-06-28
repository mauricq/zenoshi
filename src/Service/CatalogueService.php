<?php


namespace App\Service;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Catalogue;
use App\Entity\Merchant;
use App\Errors\DuplicatedException;
use App\Repository\CatalogueRepository;
use App\Service\Share\IServiceProviderInterface;
use App\Utils\PrepareDataUtil;
use Doctrine\ORM\ORMException;

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
     * @var PrepareDataUtil
     */
    private PrepareDataUtil $prepareDataUtil;

    /**
     * CatalogueService constructor.
     * @param CatalogueRepository $repository
     * @param PrepareDataUtil $prepareDataUtil
     */
    public function __construct(CatalogueRepository $repository,
                                PrepareDataUtil $prepareDataUtil)
    {
        $this->repository = $repository;
        $this->prepareDataUtil = $prepareDataUtil;
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
     */
    public function filterBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array
    {
        $value = $criteria['value'];
        $criteria = ["type" => $value, "status" => "A"];
        $orderBy = empty($orderBy) ? null : ['name' => 'ASC'];

        $result = $this->repository->findBy($criteria, $orderBy, $limit, $offset);
        $data = $this->prepareDataUtil->deleteParentCatalog($value, $result);
        $data = $this->prepareDataUtil->deleteParamsFromCatalog($this->getIds(), $data);

        return $data;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        //json_key_input => id_field_db, idField, FK_Entity, FK_idEntity, FK_id_entity
        return [
            "parent" => ["id_parent", "parent", "Catalogue", "idCatalog", "id_catalog"]
        ];
    }
}