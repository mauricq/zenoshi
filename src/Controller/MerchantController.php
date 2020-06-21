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
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                MerchantService $MerchantService,
                                PersonService $personService,
                                CatalogueService $catalogueService)
    {
        parent::__construct($arrayTransformer, $serializer, $MerchantService);
        $this->personService = $personService;
        $this->catalogueService = $catalogueService;
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
     * @Route("/", name="merchantCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return parent::createGeneric($request);
    }

    /**
     * @Route("/{field}/{value}", name="merchantfilterBy", methods={"GET"})
     * @param Request $request
     * @param string $field
     * @param string $value
     * @return JsonResponse
     */
    public function merchantFilterBy(Request $request, string $field, string $value): JsonResponse
    {
        return parent::filterBy($request, $field, $value);
    }

    /**
     * @Route("/{id}", name="merchantUpdate", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return parent::createGeneric($request, $id);
    }

    /**
     * @Route("/{id}", name="merchantDelete", methods={"DELETE"})
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        return parent::delete($id);
    }
}