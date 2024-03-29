<?php
declare(strict_types=1);

namespace AuthenticationApi\Dto;

use SwaggerBake\Lib\Attribute\OpenApiSchema;
use SwaggerBake\Lib\Attribute\OpenApiSchemaProperty;

#[OpenApiSchemaProperty(name: 'email', type: 'string', example: 'test@example.com', isRequired: true)]
#[OpenApiSchemaProperty(name: 'password', type: 'string', example: 'password', isRequired: true)]
class UserLoginRequest
{

}
