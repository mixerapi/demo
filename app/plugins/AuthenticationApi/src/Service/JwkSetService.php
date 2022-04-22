<?php
declare(strict_types=1);

namespace AuthenticationApi\Service;

use AuthenticationApi\Plugin;
use Cake\Http\Exception\InternalErrorException;
use Firebase\JWT\JWT;

class JwkSetService
{
    /**
     * Generates a JWK Set.
     *
     * @param string|null $pubKeyFile Path to the public key [default: config/public.pem]
     * @return array
     */
    public function keyset(?string $pubKeyFile = null): array
    {
        $pubKeyFile = $pubKeyFile ?? (new Plugin())->getConfigPath() . 'public.pem';

        if (!file_exists($pubKeyFile)) {
            throw new InternalErrorException("Keys not found, unable to locate key file.");
        }
        if (!is_readable($pubKeyFile)) {
            throw new InternalErrorException("Keys not readable, unable to read the contents of the key file.");
        }
        $pubKey = file_get_contents($pubKeyFile);
        if ($pubKey === false) {
            throw new InternalErrorException("Error getting the contents of the key file.");
        }

        $res = openssl_pkey_get_public($pubKey);
        $detail = openssl_pkey_get_details($res);
        $key = [
            'kid' => 'abc123',
            'kty' => 'RSA',
            'alg' => 'RS256',
            'use' => 'sig',
            'e' => JWT::urlsafeB64Encode($detail['rsa']['e']),
            'n' => JWT::urlsafeB64Encode($detail['rsa']['n']),
        ];
        $keys['keys'][] = $key;

        return $keys;

    }

    /**
     * Returns the private key
     *
     * @param string|null $keyFile Path to the private key [default: config/private.pem]
     * @return string
     */
    public function getPrivateKey(?string $keyFile = null): string
    {
        $keyFile = $keyFile ?? (new Plugin())->getConfigPath() . 'private.pem';

        if (!file_exists($keyFile)) {
            throw new InternalErrorException("Keys not found, unable to locate key file.");
        }
        if (!is_readable($keyFile)) {
            throw new InternalErrorException("Keys not readable, unable to read the contents of the key file.");
        }
        $privateKey = file_get_contents($keyFile);
        if ($privateKey === false) {
            throw new InternalErrorException("Error getting the contents of the key file.");
        }

        return $privateKey;
    }
}
