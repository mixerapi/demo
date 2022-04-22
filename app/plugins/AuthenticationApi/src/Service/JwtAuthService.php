<?php
declare(strict_types=1);

namespace AuthenticationApi\Service;

use Authentication\AuthenticationService;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class JwtAuthService implements JwtAuthInterface
{
    use AuthTrait;

    /**
     * CakePHP Authenticators and Identifiers.
     *
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    public function getService(AuthenticationService $service): AuthenticationService
    {
        $service = self::loadFormAuth($service);

        $service->loadAuthenticator('Authentication.Jwt', [
            'secretKey' => $this->getSecretKey(),
            'algorithm' => 'HS256',
        ]);

        return self::loadPasswordIdentifier($service);
    }

    /**
     * @inheritDoc
     */
    public function auth(AuthenticationComponent $authenticationComponent): string
    {
        $payload = self::authenticate($authenticationComponent);
        return JWT::encode($payload, $this->getSecretKey());
    }

    private function getSecretKey(): string
    {
        return Security::hash(Security::getSalt(), 'sha256');
    }
}
