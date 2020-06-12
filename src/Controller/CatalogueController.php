<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Service\CatalogueService;
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
     * Catalogue constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param CatalogueService $userService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                CatalogueService $userService)
    {
        parent::__construct($arrayTransformer, $serializer, $userService);
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
        return parent::filterBy($request, $type);
    }
}