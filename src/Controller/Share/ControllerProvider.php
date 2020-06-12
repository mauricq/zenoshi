<?php


namespace App\Controller\Share;


use App\Entity\Constants;
use App\Service\Share\IServiceProviderInterface;
use App\Utils\Utils;
use Exception;
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
     * @var ArrayTransformerInterface
     */
    protected $arrayTransformer;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var IServiceProviderInterface
     */
    protected $service;

    /**
     * @var Utils
     */
    public $util;

    /**
     * @required
     * @param Utils $util
     */
    public function setUtil(Utils $util): void
    {
        $this->util = $util;
    }

    /**
     * ReportControllerProvider constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param IServiceProviderInterface $userService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                IServiceProviderInterface $userService)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
        $this->service = $userService;
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
     * @param string $type
     * @return JsonResponse
     */
    public function filterBy(Request $request, string $type): JsonResponse
    {
        $criteria = ["type" => $type, "status" => "A"];

        $orderBy = $request->query->get("orderBy", 'name');
        $limit = $request->query->get("limit", null);
        $offset = $request->query->get("offset", null);

        $data = $this->service->filterBy($criteria, [$orderBy => 'ASC'], $limit, $offset);
        return new JsonResponse(
            array(
                Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($data)
            ),
            Response::HTTP_OK
        );
    }
}