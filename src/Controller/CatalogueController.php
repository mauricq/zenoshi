<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Catalogue;
use App\Entity\Constants;
use App\Service\CatalogueService;
use App\Utils\PrepareDataUtil;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

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
     * @Route("/", name="catalogueCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function create(Request $request): JsonResponse
    {
        return parent::createGeneric($request, Catalogue::class);
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

    /**
     * @Route("/{id}", name="catalogueUpdate", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return parent::createGeneric($request, Catalogue::class, $id);
    }

    /**
     * @Route("/{id}", name="catalogueDelete", methods={"DELETE"})
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        return parent::deleteLogic($id);
    }
}