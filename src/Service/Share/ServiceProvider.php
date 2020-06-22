<?php


namespace App\Service\Share;


use App\Entity\EntityProvider;
use App\Utils\PrepareDataUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ServiceProvider
{
    /**
     * @var PrepareDataUtil
     */
    protected PrepareDataUtil $prepareDataUtil;
    /**
     * @var array
     */
    private array $criteriaFields = [];

    /**
     * ServiceProvider constructor.
     * @param PrepareDataUtil $prepareDataUtil
     */
    public function __construct(PrepareDataUtil $prepareDataUtil)
    {
        $this->prepareDataUtil = $prepareDataUtil;
    }

    /**
     * @param array $fields
     * @param EntityProvider $object
     * @return array
     */
    public function getCriteriaFields(array $fields, EntityProvider $object): ?array
    {
        if (!array_key_exists('fields', $fields)) return [];

        foreach ($fields['fields'] as $field) {
            $getCheckFields = $this->prepareDataUtil->getGetMethodByIdName($field);
            $this->criteriaFields[$field] = $object->$getCheckFields();
        }

        return $this->criteriaFields;
    }

    /**
     * @param array $fieldsCheckDuplicated
     * @param EntityProvider $object
     * @param ServiceEntityRepository $repository
     * @return bool
     */
    public function isDuplicated(array $fieldsCheckDuplicated, EntityProvider $object, ServiceEntityRepository $repository): bool
    {
        $enabledCheckDuplicated = array_key_exists('enabled', $fieldsCheckDuplicated) ?
            $fieldsCheckDuplicated['enabled'] : false;
        if (!$enabledCheckDuplicated) return false;

        $check = true;
        if (empty($repository->findOneBy($this->criteriaFields))) {
            $check = false;
        }
        return $check;
    }

}