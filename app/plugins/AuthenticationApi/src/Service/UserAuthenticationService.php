<?php
declare(strict_types=1);

namespace AuthenticationApi\Service;

use Authentication\AuthenticationService;
use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Identifier\IdentifierInterface;
use AuthenticationApi\Controller\AuthenticationController;
use AuthenticationApi\Identity\Resolver\JwtResolver;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;

class UserAuthenticationService
{
    /**
     * Returns a JWT on success or throws UnauthenticatedException.
     *
     * @param AuthenticationController $controller
     * @return string
     * @throws UnauthenticatedException|\Exception
     */
    public function auth(AuthenticationController $controller): string
    {
        $result = $controller->Authentication->getResult();

        if ($result->isValid()) {
            $user = $result->getData();
            $payload = [
                'iss' => 'mixerapi',
                'sub' => $user->id,
                'exp' => time() + 60 * 60 * 24,
                'user' => [
                    'email' => $user->email
                ]
            ];
            return JWT::encode($payload, Security::hash(Security::getSalt(), 'sha256'), 'HS256');
        }

        throw new UnauthenticatedException();
    }

    /**
     * Loads authenticators and identifiers into the AuthenticationService depending on the API.
     *
     * @param ServerRequestInterface $request
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    public function getService(ServerRequestInterface $request, AuthenticationService $service): AuthenticationService
    {
        if ($this->isAuthenticationApi($request)) {
            $service->loadAuthenticator('Authentication.Form', [
                'fields' => [
                    IdentifierInterface::CREDENTIAL_USERNAME => 'email',
                    IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
                ]
            ]);

            // note: use a real identifier/resolver here instead
            $service->loadIdentifier('Authentication.Callback', [
                'callback' => function ($data) {
                    return (new JwtResolver())->find([]);
                }
            ]);
        } else {
            $service->loadAuthenticator('Authentication.Jwt', [
                'secretKey' => Security::hash(Security::getSalt(), 'sha256'),
                'algorithm' => 'HS256',
            ]);
        }

        return $service;
    }

    /**
     * Is this request for the Authentication API?
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    private function isAuthenticationApi(ServerRequestInterface $request): bool
    {
        $attributes = $request->getAttributes();
        return isset($attributes['params']['plugin']) && $attributes['params']['plugin'] == 'AuthenticationApi';
    }
}
