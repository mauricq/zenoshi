<?php


namespace App\Security;


use App\Entity\Constants;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class AppKeyAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     * - For a form login, you might redirect to the login page
     * - For an API token authentication system, you return a 401 response
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null) : Response
    {
        return new Response(Constants::UNAUTHORIZED_MESSAGE, 401, ["Content-Type" => "application/json"]);
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request) : bool
    {
        return $request->headers->has(Constants::APP_KEY_HEADER_NAME);
    }

    /**
     * @param Request $request
     * @return string|null
     */
    public function getCredentials(Request $request): ?string
    {
        return $request->headers->get(Constants::APP_KEY_HEADER_NAME);
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider) : ?UserInterface
    {
        return !empty($credentials) ? $this->entityManager->getRepository(User::class)->findOneBy(['appKey' => $credentials]): null;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user) : bool
    {
        return $user->getAppKey() === $credentials;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) : ?Response
    {
        return new Response(Constants::AUTHENTICATION_FAILED_MESSAGE, 403, ["Content-Type" => "application/json"]);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) : ?Response
    {
        return null;
    }

    /**
     * @return bool
     */
    public function supportsRememberMe() : bool
    {
        return false;
    }
}