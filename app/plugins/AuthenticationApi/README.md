# AuthenticationApi

The AuthenticationApi uses [MixerApi/JwtAuth](https://github.com/mixerapi/jwt-auth).
See `plugins/AdminApi/src/Application.php` for loading
[CakePHP authenticators and identifiers](https://book.cakephp.org/authentication/2/en/index.html).

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

## JWKS

MixerApi/JwtAuth supports both HMAC and RSA. This demo is configured to use RSA with JSON Web Key Set (JWKS). To
retrieve you may use the Swagger UI or cURL:

```console
curl -X 'GET' \
  'http://localhost:8080/admin/auth/keys' \
  -H 'accept: application/json' \
  -H 'X-API-CLIENT: SWAGGER'
```
