<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Service\ProductService;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("product")
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends ControllerProvider
{
    /**
     * Product constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param ProductService $productService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                ProductService $productService)
    {
        parent::__construct($arrayTransformer, $serializer, $productService);
    }

    /**
     * @Route("/", name="productCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return parent::createGeneric($request);
    }

    /**
     * @Route("/{field}/{value}", name="productFilterBy", methods={"GET"})
     * @param Request $request
     * @param string $field
     * @param string $value
     * @return JsonResponse
     */
    public function filterBy(Request $request, string $field, string $value): JsonResponse
    {
        return parent::filterBy($request, $field, $value);
    }

    /**
     * @Route("/{id}", name="productUpdate", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return parent::createGeneric($request, $id);
    }

    /**
     * @Route("/{id}", name="productDelete", methods={"DELETE"})
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        return parent::delete($id);
    }
}