<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Constants;
use App\Entity\User;
use App\Service\UserService;
use App\Utils\TokenUtils;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("login")
 * Class ArticleController
 * @package App\Controller
 */
class LoginController extends ControllerProvider
{
    /**
     * @var TokenUtils
     */
    protected $tokenUtils;

    /**
     * @var JWTTokenManagerInterface
     */
    private $JWTManager;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @return TokenUtils
     */
    public function getTokenUtils(): TokenUtils
    {
        return $this->tokenUtils;
    }

    /**
     * @required
     * @param TokenUtils $tokenUtils
     */
    public function setTokenUtils(TokenUtils $tokenUtils): void
    {
        $this->tokenUtils = $tokenUtils;
    }

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
     * @param UserService $userService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                UserService $userService)
    {
        parent::__construct($arrayTransformer, $serializer, $userService);
    }


    /**
     * @Route("/", name="login", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $body = $request->getContent();
        $user = $this->serializer->deserialize($body, User::class, Constants::REQUEST_FORMAT_JSON);
        $user->setPassword($request->get(Constants::LOGIN_PASSWORD_LABEL));


        $jwt = $this->JWTManager->create($user);
        $response = new JWTAuthenticationSuccessResponse($jwt);

        $event = new AuthenticationSuccessEvent(['token' => $jwt], $user, $response);
        $this->dispatcher->dispatch($event);
        $response->setData($event->getData());

        return $response;
    }

}