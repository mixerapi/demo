<?php

namespace AuthenticationApi\Identity\Resolver;

use Authentication\Identifier\Resolver\ResolverInterface;
use Cake\ORM\Entity;

class JwtResolver implements ResolverInterface
{
    public function find(array $conditions, string $type = self::TYPE_AND)
    {
        return new Entity([
            'id' => '1b5ecd1f-2f6e-49a9-b9b2-c9d2551c1bf1',
            'email' => 'test@example.com'
        ]);
    }
}
