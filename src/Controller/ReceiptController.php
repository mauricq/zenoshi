<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Receip;
use App\Service\ReceiptService;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("receipt")
 * Class ReceiptController
 * @package App\Controller
 */
class ReceiptController extends ControllerProvider
{
    /**
     * Receipt constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param ReceiptService $receiptService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                ReceiptService $receiptService)
    {
        parent::__construct($arrayTransformer, $serializer, $receiptService);
    }

    /**
     * @Route("/", name="receiptCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function create(Request $request): JsonResponse
    {
        return parent::createGeneric($request, Receip::class);
    }

    /**
     * @Route("/{field}/{value}", name="receiptFilterBy", methods={"GET"})
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
     * @Route("/{id}", name="receiptUpdate", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return parent::createGeneric($request, Receip::class, $id);
    }

    /**
     * @Route("/{id}", name="receiptDelete", methods={"DELETE"})
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        return parent::delete($id);
    }
}