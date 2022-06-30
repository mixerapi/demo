<?php

namespace AuthenticationApi\Test;

use App\Model\Entity\User;
use Cake\Chronos\Date;
use Cake\Utility\Text;
use MixerApi\JwtAuth\Configuration\Configuration;
use MixerApi\JwtAuth\JwtAuthenticator;

class JwtHelper
{
    /**
     * Returns a JWT for use with writing tests for endpoints that require JWT authentication.
     *
     * @return string
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public static function getJwt(): string
    {
        $user = new User();
        $user->set('id', Text::uuid());
        $user->set('email', 'test@example.com');
        $user->set('created', Date::now());
        $user->set('modified', Date::now());

        return (new JwtAuthenticator(new Configuration()))->authenticate($user->getJwt());
    }
}
