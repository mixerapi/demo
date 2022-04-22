<?php
declare(strict_types=1);

namespace AuthenticationApi\Dto;

use SwaggerBake\Lib\Attribute\OpenApiSchemaProperty;

#[OpenApiSchemaProperty(name: 'kty', example: 'RSA')]
#[OpenApiSchemaProperty(name: 'use', example: 'sig')]
#[OpenApiSchemaProperty(name: 'alg', example: 'RS256')]
#[OpenApiSchemaProperty(name: 'kid')]
#[OpenApiSchemaProperty(name: 'n')]
#[OpenApiSchemaProperty(name: 'e')]
class JwkSetResponse
{

}
