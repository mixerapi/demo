<?php
declare(strict_types=1);

namespace AuthenticationApi;

use Authentication\AuthenticationService;
use Authentication\Identifier\IdentifierInterface;
use Cake\Cache\Cache;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\Jwk\JwkSet;

class JwtAuthService
{
    /**
     * Returns an instance of the CakePHP AuthenticationService
     *
     * @return AuthenticationService
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public static function create(): AuthenticationService
    {
        $usernameField = 'email';
        $passwordField = 'password';

        $config = new Configuration;
        $service = new AuthenticationService();
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => $usernameField,
                IdentifierInterface::CREDENTIAL_PASSWORD => $passwordField,
            ],
            'loginUrl' => '/admin/auth/login'
        ]);

        $service->loadIdentifier('Authentication.JwtSubject');

        if (str_starts_with(haystack: $config->getAlg(), needle: 'HS')) {
            $service->loadAuthenticator('Authentication.Jwt', [
                'secretKey' => $config->getSecret(),
                'algorithm' => $config->getAlg(),
            ]);
        } else if (str_starts_with(haystack: $config->getAlg(), needle: 'RS')) {
            $jsonKeySet = Cache::remember('jwkset', function() {
                return json_encode((new JwkSet)->getKeySet());
            });

            /*
             * Caching is optional, you may also set the jwks key to the return value of (new JwkSet)->getKeySet()
             */
            $service->loadAuthenticator('Authentication.Jwt', [
                'jwks' => json_decode($jsonKeySet, true),
                'algorithm' => $config->getAlg(),
            ]);
        }

        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                IdentifierInterface::CREDENTIAL_USERNAME => $usernameField,
                IdentifierInterface::CREDENTIAL_PASSWORD => $passwordField,
            ]
        ]);

        return $service;
    }
}
