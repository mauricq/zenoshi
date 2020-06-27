<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Merchant;
use App\Service\MerchantService;
use ErrorException;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("merchant")
 * Class MerchantController
 * @package App\Controller
 */
class MerchantController extends ControllerProvider
{
    /**
     * Merchant constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param MerchantService $merchantService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                MerchantService $merchantService)
    {
        parent::__construct($arrayTransformer, $serializer, $merchantService);
    }

    /**
     * @Route("/", name="merchantCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function create(Request $request): JsonResponse
    {
        return parent::createGeneric($request, Merchant::class);
    }

    /**
     * @Route("/{field}/{value}", name="merchantFilterBy", methods={"GET"})
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
     * @Route("/{id}", name="merchantUpdate", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return parent::createGeneric($request, Merchant::class, $id);
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