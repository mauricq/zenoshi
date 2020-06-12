<?php


namespace App\Security;


use App\Entity\Constants;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\HttpFoundation\Request;

class JWTTokenAuthenticator extends BaseAuthenticator
{
    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return !$request->headers->has(Constants::APP_KEY_HEADER_NAME) &&  false !== $this->getTokenExtractor()->extract($request);
    }
}