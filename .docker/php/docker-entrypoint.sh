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

        salt=$(openssl rand -base64 32)
        sed -i '/export SECURITY_SALT/c\export SECURITY_SALT="'$salt'"' config/.env

        touch .gitkeep
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
        openssl rand -base64 32 > plugins/AuthenticationApi/config/keys/hmac_secret.txt
    fi

    echo "setting ownership..."
    chown -R cakephp:www-data .

    echo "setting permissions..."
    chmod 774 -R .

    echo "waiting for fpm..."
fi

exec docker-php-entrypoint "$@"
