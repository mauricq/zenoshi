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
 * @Route("catalogue")
 * Class ArticleController
 * @package App\Controller
 */
class CatalogueController extends ControllerProvider
{

    /**
     * Catalogue constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param CatalogueService $service
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                CatalogueService $service)
    {
        parent::__construct($arrayTransformer, $serializer, $service);
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
     * @Route("/{value}", name="catalogueControllerFilterBy", methods={"GET"})
     * @param Request $request
     * @param string $value
     * @return JsonResponse
     */
    public function filterByType(Request $request, string $value): JsonResponse
    {
        return parent::filterBy($request, "value", $value);
    }
}