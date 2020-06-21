<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Service\PersonService;
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
class PersonController extends ControllerProvider
{
    /**
     * Person constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param PersonService $service
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                PersonService $service)
    {
        parent::__construct($arrayTransformer, $serializer, $service);
    }


    /**
     * @Route("/person", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return parent::create($request);
    }
}