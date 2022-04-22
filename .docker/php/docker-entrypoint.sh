#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/cakephp' ]; then

    # The first time volumes are mounted, the project needs to be recreated
    if [ ! -f composer.json ]; then

        if [ -f .gitkeep ]; then
            rm .gitkeep # create project fails if directory is not empty
        fi

        COMPOSER_MEMORY_LIMIT=-1
        composer create-project --prefer-dist --no-interaction cakephp/app:~4.2 .
        rm -rf .github
        cp config/.env.example config/.env
        cp config/app_local.example.php config/app_local.php
        cp ../.assets/bootstrap.php config/bootstrap.php

        sed -i '/export APP_NAME/c\export APP_NAME="cakephp"' config/.env

        salt=$(cat /dev/urandom | LC_CTYPE=C tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
        sed -i '/export SECURITY_SALT/c\export SECURITY_SALT="'$salt'"' config/.env

        touch .gitkeep

        # For AuthenticationApi JWT Auth generate private and public keys:
        openssl genrsa -out plugins/AuthenticationApi/config/jwt.key 1024
        openssl rsa -in plugins/AuthenticationApi/config/jwt.key -outform PEM -pubout -out plugins/AuthenticationApi/config/jwt.pem

        # For JWK Set Auth:
        openssl genrsa -out private.pem 4096
        openssl rsa -in private.pem -out public.pem -pubout
        openssl req -key private.pem -new -x509 -days 3650 -subj "/C=US/ST=DC/O=MixerApi/OU=Demo/CN=demo.mixerapi.com" -out cert.pem
        openssl pkcs12 -export -inkey private.pem -in cert.pem -out keys.pfx -name "my alias"
        keytool -v -list -keystore keys.pfx -storetype PKCS12 -storepass
        keytool -list -keystore keys.pfx
    fi

    echo "ENV: $APP_ENV"
    if [ "$APP_ENV" != 'prod' ]; then
        composer install --prefer-dist --no-interaction
    fi

    mkdir -p logs tmp

    echo "HOST OS: $HOST_OS"
    if [[ $HOST_OS == *"Linux"* ]]; then
        echo "Setting ACLs..."
        setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX logs
        setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX tmp
        setfacl -R -m g:nginx:rwX /srv/app
    fi

    echo "setting ownership..."
    chown -R cakephp:www-data .

    echo "setting permissions..."
    chmod 774 -R .

    echo "waiting for fpm..."
fi

exec docker-php-entrypoint "$@"
