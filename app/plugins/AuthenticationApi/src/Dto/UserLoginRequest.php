<?php
namespace AuthenticationApi\Dto;

use Cake\Http\ServerRequest;
use SwaggerBake\Lib\Attribute\OpenApiSchema;
use SwaggerBake\Lib\Attribute\OpenApiSchemaProperty;

#[OpenApiSchema]
class UserLoginRequest
{
    /**
     * @param string $email User email address
     * @param string $password User password
     */
    public function __construct(
        #[OpenApiSchemaProperty(name: 'email', type: 'string', isRequired: true)]
        private string $email,
        #[OpenApiSchemaProperty(name: 'password', type: 'string', isRequired: true)]
        private string $password,
    )
    {

    }
}
