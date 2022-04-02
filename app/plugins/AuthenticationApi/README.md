# AuthenticationApi

This is an example of a JWT-based authentication. Keys should've been generated as part of the
`.docker/php/docker-entrypoint.sh` script. If not you can login into the container and generate them:

```console
openssl genrsa -out plugins/AuthenticationApi/config/jwt.key 1024
openssl rsa -in plugins/AuthenticationApi/config/jwt.key -outform PEM -pubout -out plugins/AuthenticationApi/config/jwt.pem
```

To get a JWT, browse to `http://localhost:8080/auth` or directly via cURL:

```console
curl -X 'POST' \
  'http://localhost:8080/auth/login' \
  -H 'accept: text/plain' \
  -H 'Content-Type: application/json' \
  -H 'X-API-CLIENT: SWAGGER' \
  -d '{
  "email": "string",
  "password": "string"
}'
```
