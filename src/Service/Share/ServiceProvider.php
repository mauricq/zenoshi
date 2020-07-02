<?php


namespace App\Service\Share;


use App\Entity\EntityProvider;
use App\Utils\PrepareDataUtil;
use DateTime;
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
     * @var string
     */
    private string $dateTimeFormat;

    /**
     * ServiceProvider constructor.
     * @param PrepareDataUtil $prepareDataUtil
     * @param string $dateTimeFormat
     */
    public function __construct(PrepareDataUtil $prepareDataUtil, string $dateTimeFormat)
    {
        $this->prepareDataUtil = $prepareDataUtil;
        $this->dateTimeFormat = $dateTimeFormat;
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
            $dataField = $object->$getCheckFields();
//            if ($dataField instanceof DateTime) $dataField = $dataField->format($this->dateTimeFormat);
            $this->criteriaFields[$field] = $dataField;
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