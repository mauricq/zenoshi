<?php


namespace App\Utils;


use App\Entity\Constants;
use App\Entity\EntityProvider;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PrepareDataUtil
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
     * PrepareDataUtil constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer, SerializerInterface $serializer)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
    }

    /**
     * @param string $catalogName
     * @param array $object
     * @return array
     */
    public function deleteParentCatalog(string $catalogName, array $object): array
    {
        $catalogName = str_replace("_", " ", strtoupper($catalogName));
        $index = "";
        foreach ($object as $key => $cat) {
            if ($catalogName === strtoupper($cat->getName()) OR strtoupper(Constants::CATALOG_LABEL) === strtoupper($cat->getDescription())) {
                $index = $key;
                break;
            }
        }
        unset($object[$index]);

        return array_values($object);
    }

    /**
     * @param string $paramName
     * @param string $id_ParamName
     * @param array $data
     * @return array
     */
    public function deleteParamFromCatalog(string $paramName, string $id_ParamName, array $data): array
    {
        foreach ($data as $key => &$cat) {
            if (!array_key_exists($paramName, $cat) ) return $data;
            $value = $cat[$paramName][$id_ParamName];
            unset($cat[$paramName]);
            $cat[$paramName] = $value;
        }

        return $data;
    }

    /**
     * @param array $ids
     * @param array $object
     * @return array
     */
    public function deleteParamsFromCatalog(array $ids , array $object): array
    {
        $paramName = Constants::PREPARED_DATA_ID_FIELD_DB;
        $id_ParamName = Constants::PREPARED_DATA_FK_ID_ENTITY;

        $data = $this->arrayTransformer->toArray($object); //TODO Merchant id_person=1
        foreach ($ids as $key => $id) {
            $data = $this->deleteParamFromCatalog($id[$paramName], $id[$id_ParamName], $data);
        }

        return $data;
    }

    /**
     * @param Request $request
     * @param array $ids
     * @return array
     * @throws ExceptionInterface
     */
    public function prepareData(Request $request, array $ids): array
    {
        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());

        $id_field = Constants::PREPARED_DATA_ID_FIELD;
        $fk_entity = Constants::PREPARED_DATA_FK_ENTITY;
        $fk_id_entity = Constants::PREPARED_DATA_FK_IDENTITY;
        $data = [];
        foreach ($ids as $key => $val) {
            $idValue = $request->get($key);
            if (empty($idValue)) continue;
            $idEntity = $val[$id_field];
            $method = $this->getSetMethodByIdName($val[$fk_id_entity]);
            $entity = Constants::PREPARED_DATA_PATH_ENTITY . $val[$fk_entity];
            $object = new $entity();
            if (is_array($idValue)) {
                $entityDenormalized = $normalizer->denormalize($idValue, $entity);
                $data[$idEntity] = $entityDenormalized;
            }
            else {
                $object->$method($idValue);
                $data[$idEntity] = $object;
            }
        }

        return $data;
    }

    /**
     * @param object $object
     * @param array $relations
     * @param array $ids
     * @return object
     */
    public function joinPreparedData(object $object, array $relations, array $ids): object
    {
        $id_field = Constants::PREPARED_DATA_ID_FIELD;
        foreach ($ids as $key => $val) {
            $fk_entity = $val[$id_field];
            $method = $this->getSetMethodByIdName($fk_entity);
            if (!array_key_exists($fk_entity, $relations)) continue;
            $object->$method($relations[$fk_entity]);
        }
        return $object;
    }

    /**
     * @param string $idName
     * @return string
     */
    public function getSetMethodByIdName(string $idName): string
    {
        return "set" . ucwords($idName);
    }

    /**
     * @param string $idName
     * @return string
     */
    public function getGetMethodByIdName(string $idName): string
    {
        return "get" . ucwords($idName);
    }

}