<?php


namespace App\Controller\Share;


use App\Entity\Constants;
use App\Entity\Merchant;
use App\Errors\DuplicatedException;
use App\Service\Share\IServiceProviderInterface;
use App\Utils\PrepareDataUtil;
use App\Utils\Utils;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ControllerProvider
 * @package App\Controller\Share
 */
class ControllerProvider extends AbstractController implements IControllerProviderInterface
{
    /**
     * @var PrepareDataUtil
     */
    private PrepareDataUtil $prepareDataUtil;
    /**
     * @var ArrayTransformerInterface
     */
    protected ArrayTransformerInterface $arrayTransformer;
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;
    /**
     * @var IServiceProviderInterface
     */
    protected IServiceProviderInterface $service;
    /**
     * @var Utils
     */
    public Utils $util;
    /**
     * @required
     * @param Utils $util
     */
    public function setUtil(Utils $util): void
    {
        $this->util = $util;
    }
    /**
     * @required
     * @param PrepareDataUtil $prepareDataUtil
     */
    public function setPrepareDataUtil(PrepareDataUtil $prepareDataUtil): void
    {
        $this->prepareDataUtil = $prepareDataUtil;
    }

    /**
     * ReportControllerProvider constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param IServiceProviderInterface $service
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                IServiceProviderInterface $service)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $body = $request->getContent();
            $object = $this->serializer->deserialize($body, $this->service->getClass(), Constants::REQUEST_FORMAT_JSON);
            $objectResult = $this->service->save($object);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($objectResult)
                ),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $error = join('-', [$e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode(), $e->getTraceAsString()]);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR,
                    Constants::RESULT_LABEL_DATA => $error
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return $result;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createGeneric(Request $request): JsonResponse
    {
        try {
            $body = $request->getContent();
            $object = $this->serializer->deserialize($body, Merchant::class, Constants::REQUEST_FORMAT_JSON);
            $relations = $this->prepareDataUtil->prepareData($request, $this->service->getIds());
            $object = $this->prepareDataUtil->joinPreparedData($object, $relations, $this->service->getIds());
            try {
                $person = $this->service->saveV2($object);
            } catch (DuplicatedException $e) {
                return new JsonResponse(
                    array(
                        Constants::RESULT_LABEL_STATUS => Constants::RESULT_DUPLICATED,
                        Constants::RESULT_LABEL_DATA => $e->getMessage()
                    ),
                    Response::HTTP_CONFLICT
                );
            }

            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($person)
                ),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $error = join('-', [$e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode(), $e->getTraceAsString()]);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR,
                    Constants::RESULT_LABEL_DATA => $error
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return $result;
    }

    /**
     * @param string $value
     * @return JsonResponse
     */
    public function delete(string $value): JsonResponse
    {
        try {
            $this->service->delete($value);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS
                ),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return $result;
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $data = $this->service->getAll();
        return new JsonResponse(
            array(
                Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($data)
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @param string $value
     * @return JsonResponse
     */
    public function filterOneBy(string $value): JsonResponse
    {
        $data = $this->service->filterOneBy($value);
        return new JsonResponse(
            array(
                Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($data)
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @param string $field
     * @param string $value
     * @return JsonResponse
     */
    public function filterBy(Request $request, string $field, string $value): JsonResponse
    {
        $criteria = [$field => $value];

        $orderBy = $request->query->get("orderBy", null);
        $limit = $request->query->get("limit", null);
        $offset = $request->query->get("offset", null);

        $orderBy = empty($orderBy) ? null : [$orderBy => 'ASC']; //TODO $orderBy separated by coma.
        $data = $this->service->filterBy($criteria, $orderBy, $limit, $offset);
        return new JsonResponse(
            array(
                Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($data)
            ),
            Response::HTTP_OK
        );
    }
}