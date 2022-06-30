<?php

namespace AuthenticationApi\Test;

use App\Model\Entity\User;
use Cake\Chronos\Date;
use Cake\Utility\Text;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\JwtAuthenticator;

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
