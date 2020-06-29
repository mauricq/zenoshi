<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Catalogue;
use App\Entity\Constants;
use App\Entity\Person;
use App\Entity\User;
use App\Errors\DuplicatedException;
use App\Service\CatalogueService;
use App\Service\UserCreateService;
use App\Service\UserService;
use App\Service\PersonService;
use App\Utils\UserUtil;
use ErrorException;
use Exception;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("user")
 * Class UserController
 * @package App\Controller
 */
class UserController extends ControllerProvider
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var PersonService
     */
    private PersonService $personService;

    /**
     * @var CatalogueService
     */
    private CatalogueService $catalogueService;
    /**
     * @var UserUtil
     */
    private UserUtil $userUtil;
    /**
     * @var UserCreateService
     */
    private UserCreateService $userCreateService;

    /**
     * User constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param UserService $service
     * @param PersonService $personService
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param CatalogueService $catalogueService
     * @param UserUtil $userUtil
     * @param UserCreateService $userCreateService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                UserService $service,
                                PersonService $personService,
                                UserPasswordEncoderInterface $passwordEncoder,
                                CatalogueService $catalogueService,
                                UserUtil $userUtil,
                                UserCreateService $userCreateService)
    {
        parent::__construct($arrayTransformer, $serializer, $service);
        $this->passwordEncoder = $passwordEncoder;
        $this->personService = $personService;
        $this->catalogueService = $catalogueService;
        $this->userUtil = $userUtil;
        $this->userCreateService = $userCreateService;
    }


    /**
     * @Route("/{id}", name="getUserInfo", methods={"GET"})
     * @param string $articleNumber
     * @return JsonResponse
     */
    public function getUserInfo(string $articleNumber): JsonResponse
    {
        try {
            $result = array('data' => 'test');
        } catch (ErrorException $error) {
            $message = sprintf("Fatal error: (%d) %s", $error->getCode(), $error->getMessage());
            return new JsonResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return empty($result) ? new JsonResponse([], Response::HTTP_NOT_FOUND) : new JsonResponse($result, Response::HTTP_OK);
    }

    /**
     * @Route("/", name="userCreate", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $userObjectResult = $this->userCreateService->create($request);

            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($userObjectResult)
                ),
                Response::HTTP_CREATED
            );

        } catch (DuplicatedException $de) {
            return new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_DUPLICATED,
                    Constants::RESULT_LABEL_DATA => $de->getMessage()
                ),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $error = join('-', [$e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode(), $e->getTraceAsString()]);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR,
                    Constants::RESULT_LABEL_DATA => $error
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return $result;
    }
}