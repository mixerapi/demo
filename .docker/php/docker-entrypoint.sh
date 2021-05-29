#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/cakephp' ]; then

    chown -R cakephp:www-data .

    #if [ "$APP_ENV" = 'prod' ]; then
    #    composer install --prefer-dist --no-interaction --no-dev
    #else
    #    composer install --prefer-dist --no-interaction
    #fi

    mkdir -p logs tmp/cache/models tmp/cache/models/persistent tmp/sessions tmp/tests
    chown -R cakephp:www-data logs tmp
    chmod 775 -R logs tmp
    setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX logs
    setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX tmp
    bin/cake cache clear_all

fi

exec docker-php-entrypoint "$@"
