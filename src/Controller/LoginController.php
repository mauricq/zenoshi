<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Constants;
use App\Errors\DuplicatedException;
use App\Service\BaseUrl;
use App\Service\UserCreateService;
use App\Service\UserService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ArticleController
 * @package App\Controller
 */
class LoginController extends ControllerProvider
{
    /**
     * @var JWTTokenManagerInterface
     */
    private JWTTokenManagerInterface $JWTManager;
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $dispatcher;
    /**
     * @var UserCreateService
     */
    private UserCreateService $userCreateService;

    /**
     * @required
     * @param JWTTokenManagerInterface $JWTManager
     */
    public function setJWTManager(JWTTokenManagerInterface $JWTManager): void
    {
        $this->JWTManager = $JWTManager;
    }

    /**
     * @required
     * @param EventDispatcherInterface $dispatcher ,
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Login constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param UserService $service
     * @param UserCreateService $userCreateService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                UserService $service,
                                UserCreateService $userCreateService)
    {
        parent::__construct($arrayTransformer, $serializer, $service);
        $this->userCreateService = $userCreateService;
    }

    /**
     * This method creates a user and a person, then returns the token and the user data.
     *
     * @Route({"/register","/login/"}, name="userRegister", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function userRegister(Request $request): JsonResponse
    {
        try {
            $userObject = $this->userCreateService->create($request);
            $userObject->setPassword($request->get(Constants::LOGIN_LABEL_PASSWORD));

            $jwt = $this->JWTManager->create($userObject);
            $response = new JWTAuthenticationSuccessResponse($jwt);

            $event = new AuthenticationSuccessEvent(['token' => $jwt], $userObject, $response);
            $this->dispatcher->dispatch($event);

            $response = ['token' => $jwt, 'user' => $userObject];
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($response)
                ),
                Response::HTTP_CREATED
            );

        } catch (DuplicatedException $de) {
            $result = new JsonResponse(
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

    /**
     * This method authenticates the credentials, then returns the token and the user data.
     *
     * @Route("/login", name="loginNormal", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function loginNormal(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        try {
            $username = $request->get(Constants::LOGIN_LABEL_USERNAME);
            $password = $request->get(Constants::LOGIN_LABEL_PASSWORD);

            $userObject = $this->service->loadUserByUsername($username);

            $isAuthenticated = $userObject && $encoder->isPasswordValid($userObject, $password);

            if (!$isAuthenticated){
                return new JsonResponse(
                    array(
                        Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR,
                        Constants::RESULT_LABEL_DATA => Constants::AUTHENTICATION_WRONG_CREDENTIALS
                    ),
                    Response::HTTP_CREATED
                );
            }

            $jwt = $this->JWTManager->create($userObject);
            $response = new JWTAuthenticationSuccessResponse($jwt);

            $event = new AuthenticationSuccessEvent(['token' => $jwt], $userObject, $response);
            $this->dispatcher->dispatch($event);

            $response = ['token' => $jwt, 'user' => $userObject];
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($response) //TODO use normalizer
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

    /**
     * This method creates a user and a person using facebook data given yor authenticates using the credentials given,
     * then returns the token and the user data.
     *
     * @Route("/login/fb", name="loginFacebook", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function loginFacebook(Request $request): JsonResponse
    {
        try {
            $userObject = $this->userCreateService->createByFacebook($request);

            $jwt = $this->JWTManager->create($userObject);
            $response = new JWTAuthenticationSuccessResponse($jwt);

            $event = new AuthenticationSuccessEvent(['token' => $jwt], $userObject, $response);
            $this->dispatcher->dispatch($event);

            $response = ['token' => $jwt, 'user' => $userObject];
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($response) //TODO use normalizer
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