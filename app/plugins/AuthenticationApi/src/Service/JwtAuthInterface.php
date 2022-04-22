<?php

namespace AuthenticationApi\Service;

use Authentication\Controller\Component\AuthenticationComponent;

interface JwtAuthInterface
{
    /**
     * Authenticates the user and returns a JSON Web Token.
     *
     * @param AuthenticationComponent $authenticationComponent
     * @return string
     */
    public function auth(AuthenticationComponent $authenticationComponent): string;
}
