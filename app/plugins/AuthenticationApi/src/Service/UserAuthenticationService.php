<?php
declare(strict_types=1);

namespace AuthenticationApi\Service;

use Authentication\AuthenticationService;
use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Controller\Component\AuthenticationComponent;
use Authentication\Identifier\IdentifierInterface;
use AuthenticationApi\Identity\Resolver\JwtResolver;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class UserAuthenticationService
{
    /**
     * Returns a JWT on success or throws UnauthenticatedException.
     *
     * @param AuthenticationComponent $authComponent
     * @return string
     * @throws UnauthenticatedException
     */
    public function auth(AuthenticationComponent $authComponent): string
    {
        $result = $authComponent->getResult();

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

        if (count($result->getErrors())) {
            throw new UnauthenticatedException(implode('. ', $result->getErrors()));
        }
        throw new UnauthenticatedException($result->getStatus());
    }

    /**
     * CakePHP Authenticators and Identifiers.
     *
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    public function getService(AuthenticationService $service): AuthenticationService
    {
        $service->loadAuthenticator('Authentication.Jwt', [
            'secretKey' => Security::hash(Security::getSalt(), 'sha256'),
            'algorithm' => 'HS256',
        ]);

        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => 'email',
                IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
            ],
            'loginUrl' => '/auth/login'
        ]);

        // note: use a real identifier/resolver here instead
        $service->loadIdentifier('Authentication.Callback', [
            'callback' => function ($data) {
                return (new JwtResolver())->find([]);
            }
        ]);

        return $service;
    }

    /**
     * CakePHP Authenticators and Identifiers.
     *
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    public function getLoginService(AuthenticationService $service): AuthenticationService
    {
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => 'email',
                IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
            ],
            'loginUrl' => '/authentication/login'
        ]);

        // note: use a real identifier/resolver here instead
        $service->loadIdentifier('Authentication.Callback', [
            'callback' => function ($data) {
                return (new JwtResolver())->find([]);
            }
        ]);

        return $service;
    }

    public function getJwtService(AuthenticationService $service): AuthenticationService
    {
        $service->loadAuthenticator('Authentication.Jwt', [
            'secretKey' => Security::hash(Security::getSalt(), 'sha256'),
            'algorithm' => 'HS256',
        ]);

        return $service;
    }
}
