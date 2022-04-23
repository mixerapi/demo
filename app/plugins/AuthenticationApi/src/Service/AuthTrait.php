<?php

namespace AuthenticationApi\Service;

use App\Model\Entity\User;
use Authentication\AuthenticationService;
use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Controller\Component\AuthenticationComponent;
use Authentication\Identifier\IdentifierInterface;

trait AuthTrait
{
    /**
     * Returns a payload suitable for JWT encoding.
     *
     * @param AuthenticationComponent $authComponent
     * @param int|null $expiration
     * @return array
     */
    private static function authenticate(AuthenticationComponent $authComponent, ?int $expiration = null): array
    {
        $result = $authComponent->getResult();

        if ($result->isValid()) {
            /** @var User $user */
            $user = $result->getData();
            return [
                'iss' => 'mixerapi',
                'sub' => $user->id,
                'exp' => $expiration ?? time() + 60 * 60 *24,
                'user' => [
                    'email' => $user->email
                ]
            ];
        }

        if (count($result->getErrors())) {
            throw new UnauthenticatedException(implode('. ', $result->getErrors()));
        }
        throw new UnauthenticatedException($result->getStatus());
    }

    /**
     * Loads Authentication.Form
     *
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    private static function loadFormAuth(AuthenticationService $service): AuthenticationService
    {
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => 'email',
                IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
            ],
            'loginUrl' => '/admin/auth/login'
        ]);

        return $service;
    }

    /**
     * Loads Authentication.Password
     *
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    private static function loadPasswordIdentifier(AuthenticationService $service): AuthenticationService
    {
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => 'email',
                IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
            ],
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => 'Users',
            ],
            'passwordHasher' => [
                'className' => 'Authentication.Fallback',
                'hashers' => [
                    'Authentication.Default',
                    [
                        'className' => 'Authentication.Legacy',
                        'hashType' => 'md5',
                    ],
                ],
            ],
        ]);

        return $service;
    }
}
