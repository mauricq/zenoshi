<?php


namespace App\Controller;

use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 */
class Order extends AbstractController
{

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
}