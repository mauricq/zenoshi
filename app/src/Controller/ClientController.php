<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Service\ClientService;
use ErrorException;
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
class ClientController extends ControllerProvider
{
    /**
     * Client constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param ClientService $userService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                ClientService $userService)
    {
        parent::__construct($arrayTransformer, $serializer, $userService);
    }


    /**
     * @Route("/orders/{articleNumber}", name="getArticleInfo", methods={"GET"})
     * @param string $articleNumber
     * @return JsonResponse
     */
    public function getArticleInfo(string $articleNumber): JsonResponse
    {
        try {
            $result = array('data'=>'test');
        } catch(ErrorException $error) {
            $message = sprintf ("Fatal error: (%d) %s", $error->getCode(), $error->getMessage());
            return new JsonResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return empty($result) ? new JsonResponse([], Response::HTTP_NOT_FOUND) : new JsonResponse($result, Response::HTTP_OK);
    }


    /**
     * @Route("/client", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return parent::create($request);
    }
}