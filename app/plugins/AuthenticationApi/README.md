# AuthenticationApi

This is an example of a JWT-based authentication. Two examples have been built-in to the demo: JSON Web Key Set and
JSON Web Token. The demo defaults to JWKS. Please do further reading on which is best for you.

- [JWKS](#jwks)
- [JWT](#jwt)
- [Getting a Token (authenticating)](#getting-a-token)

## JWKS

JWKS publishes public keys to an endpoint that other services can use to validate the JWT. Keys are available at
`/admin/auth/keys`. Exec into the container (`make php.sh`) and generate them in the `plugins/AuthenticationApi/config/` directory:

```console
openssl genrsa -out plugins/AuthenticationApi/config/private.pem 4096
openssl rsa -in plugins/AuthenticationApi/config/private.pem -out plugins/AuthenticationApi/config/public.pem -pubout
openssl req -key plugins/AuthenticationApi/config/private.pem -new -x509 -days 3650 -subj "/C=US/ST=DC/O=MixerApi/OU=Demo/CN=demo.mixerapi.com" -out plugins/AuthenticationApi/config/cert.pem
openssl pkcs12 -export -inkey plugins/AuthenticationApi/config/private.pem -in plugins/AuthenticationApi/config/cert.pem -out plugins/AuthenticationApi/config/keys.pfx -name "my alias" -password pass:
```

## JWT

You can enable HSA based JWT tokens by doing the following:

- Alter the concrete class loaded by the service (default is `JwkSetAuthService::class`):

```php
# plugins/AuthenticationApi/Plugin.php
$container->add(JwtAuthInterface::class, JwkAuthService::class);
```

- Change the authenticator that gets loaded in AdminApi and AuthenticationApi:

```php
# plugins/AuthenticationApi/Plugin.php and plugins/AdminApi/Plugin.php
$authService = (new JwtAuthService)->getService(new AuthenticationService());
```

Exec into thecontainer (`make php.sh`) and generate keys in the `plugins/AuthenticationApi/config/` directory:

```console
openssl genrsa -out plugins/AuthenticationApi/config/jwt.key 1024
openssl rsa -in plugins/AuthenticationApi/config/jwt.key -outform PEM -pubout -out plugins/AuthenticationApi/config/jwt.pem
```

## Getting a token

To get a JWT, browse to the Swagger UI `http://localhost:8080/admin` or directly via cURL:

```console
curl -X 'POST' \
  'http://localhost:8080/admin/auth/login' \
  -H 'accept: text/plain' \
  -H 'Content-Type: application/json' \
  -H 'X-API-CLIENT: SWAGGER' \
  -d '{
  "email": "test@example.com",
  "password": "password"
}'
```

You can paste the token into Swagger UI by clicking the "Authorize" button at the top of page.
