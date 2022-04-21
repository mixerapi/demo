<?php
namespace AuthenticationApi\Dto;

use SwaggerBake\Lib\Attribute\OpenApiSchema;
use SwaggerBake\Lib\Attribute\OpenApiSchemaProperty;

#[OpenApiSchema]
#[OpenApiSchemaProperty(name: 'email', type: 'string', example: 'test@example.com', isRequired: true)]
#[OpenApiSchemaProperty(name: 'password', type: 'string', example: 'password', isRequired: true)]
class UserLoginRequest
{

}
