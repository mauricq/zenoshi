<?php


namespace App\Utils;


use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class TokenUtils
{
    /**
     * @var AuthenticationSuccessHandler
     */
    protected $authenticationSuccessHandler;

    /**
     * TokenUtils constructor.
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler
     */
    public function __construct(AuthenticationSuccessHandler $authenticationSuccessHandler)
    {
        $this->authenticationSuccessHandler = $authenticationSuccessHandler;
    }


    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        // ...

        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

    public function fooAction(UserInterface $user)
    {
        //$authenticationSuccessHandler = $this->container->get('lexik_jwt_authentication.handler.authentication_success');

        return $this->authenticationSuccessHandler->handleAuthenticationSuccess($user);
    }
}