<?php


namespace App\Utils;


use App\Entity\Constants;
use JMS\Serializer\ArrayTransformerInterface;

class PrepareDataUtil
{
    /**
     * @var ArrayTransformerInterface
     */
    protected $arrayTransformer;

    /**
     * PrepareDataUtil constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer)
    {
        $this->arrayTransformer = $arrayTransformer;
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
     * @param array $object
     * @return array
     */
    public function deleteParamFromCatalog(string $paramName, string $id_ParamName, array $object): array
    {
        $data = $this->arrayTransformer->toArray($object);
        foreach ($data as $key => &$cat) {
            $value = $cat[$paramName][$id_ParamName];
            unset($cat[$paramName]);
            $cat[$paramName] = $value;
        }

        return $data;
    }
}