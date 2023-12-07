#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/cakephp' ]; then

    # Set env file and bootstrap
    if [ ! -f config/.env ]; then
        cp config/.env.example config/.env
        cp config/app_local.example.php config/app_local.php

        sed -i '/export APP_NAME/c\export APP_NAME="cakephp"' config/.env

        salt=$(openssl rand -base64 32)
        sed -i '/export SECURITY_SALT/c\export SECURITY_SALT="'$salt'"' config/.env
    fi

    echo "ENV: $APP_ENV"
    if [ "$APP_ENV" != 'prod' ]; then
        composer install --prefer-dist --no-interaction
    fi

    mkdir -p logs tmp

    # Set ACLs for Linux users
    echo "HOST OS: $HOST_OS"
    if [[ $HOST_OS == *"Linux"* ]]; then
        echo "Setting ACLs..."
        setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX logs
        setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX tmp
        setfacl -R -m g:nginx:rwX /srv/app
    fi

    # For JWT RSA keypair and HMAC secret:
    if [ ! -f plugins/AuthenticationApi/config/keys/1/private.key ]; then
        echo "Generating RSA key pairs..."
        mkdir -p plugins/AuthenticationApi/config/keys/1
        openssl genrsa -out plugins/AuthenticationApi/config/keys/1/private.pem 2048
        openssl rsa -in plugins/AuthenticationApi/config/keys/1/private.pem -outform PEM -pubout -out plugins/AuthenticationApi/config/keys/1/public.pem
        echo "Generating HMAc secret..."
        openssl rand -base64 24 > plugins/AuthenticationApi/config/keys/hmac_secret.txt
    fi

    echo "setting ownership..."
    chown -R cakephp:www-data .

    echo "setting permissions..."
    chmod 774 -R .
    rm plugins/AdminApi/webroot/swagger.json
    touch plugins/AdminApi/webroot/swagger.json
    chmod 777 plugins/AdminApi/webroot/swagger.json
    rm webroot/swagger.json
    touch webroot/swagger.json
    chmod 777 webroot/swagger.json

    echo "waiting for fpm..."
fi

exec docker-php-entrypoint "$@"
