<?php
declare(strict_types=1);

namespace AuthenticationApi\Test;

class HttpHelper
{
    /**
     * Get headers for application/json content-type and accept.
     *
     * @return array
     */
    public static function getJsonHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Get headers for application/json content-type and accept.
     *
     * @return array
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public static function getJsonHeadersWithJwt(): array
    {
        return array_merge(self::getJsonHeaders(), ['Authorization' => 'Bearer ' . JwtHelper::getJwt()]);
    }
}
