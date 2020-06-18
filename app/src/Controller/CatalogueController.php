<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Constants;
use App\Service\CatalogueService;
use App\Utils\PrepareDataUtil;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 */
class CatalogueController extends ControllerProvider
{
    /**
     * @var PrepareDataUtil
     */
    private PrepareDataUtil $prepareDataUtil;

    /**
     * Catalogue constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param CatalogueService $userService
     * @param PrepareDataUtil $prepareDataUtil
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                CatalogueService $userService,
                                PrepareDataUtil $prepareDataUtil)
    {
        parent::__construct($arrayTransformer, $serializer, $userService);
        $this->prepareDataUtil = $prepareDataUtil;
    }


    /**
     * @Route("/catalogue", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return parent::create($request);
    }


    /**
     * @Route("/catalogue/{type}", name="controllerFilterBy", methods={"GET"})
     * @param Request $request
     * @param string $type
     * @return JsonResponse
     */
    public function controllerFilterBy(Request $request, string $type): JsonResponse
    {
        $criteria = ["type" => $type, "status" => "A"];

        $orderBy = $request->query->get("orderBy", 'name');
        $limit = $request->query->get("limit", null);
        $offset = $request->query->get("offset", null);

        $data = $this->service->filterBy($criteria, [$orderBy => 'ASC'], $limit, $offset);
        $data = $this->prepareDataUtil->deleteParentCatalog($type, $data);
        $data = $this->prepareDataUtil->deleteParamFromCatalog("id_parent", "id_catalog", $data);
        return new JsonResponse(
            array(
                Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($data)
            ),
            Response::HTTP_OK
        );
    }
}