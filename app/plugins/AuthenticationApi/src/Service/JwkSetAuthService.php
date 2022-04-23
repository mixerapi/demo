<?php
declare(strict_types=1);

namespace AuthenticationApi\Service;

use Authentication\AuthenticationService;
use Authentication\Controller\Component\AuthenticationComponent;
use Firebase\JWT\JWT;

class JwkSetAuthService implements JwtAuthInterface
{
    use AuthTrait;

    public function __construct(private ?JwkSetService $jwkSetService = null)
    {
        $this->jwkSetService = $this->jwkSetService ?? new JwkSetService();
    }

    /**
     * CakePHP Authenticators and Identifiers.
     *
     * @param AuthenticationService $service
     * @return AuthenticationService
     */
    public function getService(AuthenticationService $service): AuthenticationService
    {
        $service = self::loadFormAuth($service);

        $service->loadIdentifier('Authentication.JwtSubject');
        $service->loadAuthenticator('Authentication.Jwt', [
            'jwks' => $this->jwkSetService->keyset(),
            'returnPayload' => false
        ]);

        return self::loadPasswordIdentifier($service);
    }

    /**
     * @inheritDoc
     */
    public function auth(AuthenticationComponent $authenticationComponent): string
    {
        $payload = self::authenticate($authenticationComponent);
        return JWT::encode($payload, $this->jwkSetService->getPrivateKey(), 'RS256', 'abc123');
    }
}
