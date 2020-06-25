<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Reward;
use App\Service\RewardService;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("reward")
 * Class RewardController
 * @package App\Controller
 */
class RewardController extends ControllerProvider
{
    /**
     * Reward constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param RewardService $rewardService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                RewardService $rewardService)
    {
        parent::__construct($arrayTransformer, $serializer, $rewardService);
    }

    /**
     * @Route("/", name="rewardCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return parent::createGeneric($request, Reward::class);
    }

    /**
     * @Route("/{field}/{value}", name="rewardFilterBy", methods={"GET"})
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
     * @Route("/{id}", name="rewardUpdate", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return parent::createGeneric($request, Reward::class, $id);
    }

    /**
     * @Route("/{id}", name="rewardDelete", methods={"DELETE"})
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        return parent::delete($id);
    }
}