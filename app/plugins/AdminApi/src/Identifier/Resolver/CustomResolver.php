<?php

namespace App\Identifier\Resolver;

use Authentication\Identifier\Resolver\ResolverInterface;
use Authentication\Authenticator\UnauthenticatedException;

class CustomResolver implements ResolverInterface
{
    public function find(array $conditions, string $type = self::TYPE_AND)
    {
        if ($conditions['token'] == '123') {
            return [''];
        }
    }
}
