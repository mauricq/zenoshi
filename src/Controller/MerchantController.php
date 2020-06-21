<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Constants;
use App\Entity\Merchant;
use App\Errors\DuplicatedException;
use App\Service\CatalogueService;
use App\Service\MerchantService;
use App\Service\PersonService;
use App\Utils\PrepareDataUtil;
use ErrorException;
use Exception;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("merchant")
 * Class MerchantController
 * @package App\Controller
 */
class MerchantController extends ControllerProvider
{
    /**
     * @var PersonService
     */
    private PersonService $personService;
    /**
     * @var PrepareDataUtil
     */
    private PrepareDataUtil $prepareDataUtil;

    /**
     * @var CatalogueService
     */
    private CatalogueService $catalogueService;

    /**
     * Merchant constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param MerchantService $MerchantService
     * @param PersonService $personService
     * @param CatalogueService $catalogueService
     * @param PrepareDataUtil $prepareDataUtil
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                MerchantService $MerchantService,
                                PersonService $personService,
                                CatalogueService $catalogueService,
                                PrepareDataUtil $prepareDataUtil)
    {
        parent::__construct($arrayTransformer, $serializer, $MerchantService);
        $this->personService = $personService;
        $this->catalogueService = $catalogueService;
        $this->prepareDataUtil = $prepareDataUtil;
    }


    /**
     * @Route("/{id}", name="getMerchantInfo", methods={"GET"})
     * @param string $articleNumber
     * @return JsonResponse
     */
    public function getMerchantInfo(string $articleNumber): JsonResponse
    {
        try {
            $result = array('data' => 'test');
        } catch (ErrorException $error) {
            $message = sprintf("Fatal error: (%d) %s", $error->getCode(), $error->getMessage());
            return new JsonResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return empty($result) ? new JsonResponse([], Response::HTTP_NOT_FOUND) : new JsonResponse($result, Response::HTTP_OK);
    }


    /**
     * @Route("/", name="createMerchant", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
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
}