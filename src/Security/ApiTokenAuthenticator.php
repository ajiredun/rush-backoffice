<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

use App\Repository\ApiTokenRepository;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    private $apiTokenRepo;
    public function __construct(ApiTokenRepository $apiTokenRepo)
    {
        $this->apiTokenRepo = $apiTokenRepo;
    }

    public function supports(Request $request)
    {

        if ($request->get('rf-auth', false) && (!is_null($request->get('rf-auth')))) {
            return true;
        }

        return $request->headers->has('rf-auth')
            && 0 === strpos($request->headers->get('rf-auth'), 'Bearer ')
            && !empty(substr($request->headers->get('rf-auth'), 7));
    }

    public function getCredentials(Request $request)
    {
        if ($request->get('rf-auth', false)) {
            return $request->get('rf-auth');
        }


        $authorizationHeader = $request->headers->get('rf-auth');

        return substr($authorizationHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $this->apiTokenRepo->findOneBy([
            'token' => $credentials
        ]);

        if (!$token) {
            throw new CustomUserMessageAuthenticationException(
                'INVALID_TOKEN'
            );
        }

        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException(
                'TOKEN_EXPIRED'
            );
        }

        return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // allow the authentication to continue
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new \Exception('Not used: entry_point from other authentication is used');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
