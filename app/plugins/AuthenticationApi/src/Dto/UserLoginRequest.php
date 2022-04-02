<?php
namespace AuthenticationApi\Dto;

use SwaggerBake\Lib\Attribute\OpenApiSchema;
use SwaggerBake\Lib\Attribute\OpenApiSchemaProperty;

#[OpenApiSchema]
#[OpenApiSchemaProperty(name: 'email', type: 'string', isRequired: true)]
#[OpenApiSchemaProperty(name: 'password', type: 'string', isRequired: true)]
class UserLoginRequest
{

}
