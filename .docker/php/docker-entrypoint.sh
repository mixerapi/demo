#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/cakephp' ]; then

    chown -R cakephp:www-data .
    setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX logs
    setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX tmp

    if [ "$APP_ENV" = 'prod' ]; then
        composer install --prefer-dist --no-interaction --no-dev
    else
        composer install --prefer-dist --no-interaction
    fi

fi

exec docker-php-entrypoint "$@"
