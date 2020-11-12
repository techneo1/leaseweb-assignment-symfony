#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
    PHP_INI_RECOMMENDED="$PHP_INI_DIR/php.ini-production"
    PHP_FPM_CONF_DIR="/usr/local/etc/php-fpm.d"

    if [ "$APP_ENV" != 'prod' ]; then
        PHP_INI_RECOMMENDED="$PHP_INI_DIR/php.ini-development"
    fi

    ln -sf "$PHP_INI_RECOMMENDED" "$PHP_INI_DIR/php.ini"
    /opt/bin/envsubst < /usr/local/etc/php-fpm.conf.template > "$PHP_FPM_CONF_DIR/x-lsw.conf"

	export APP_SECRET=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 64 | head -n 1)
	# Permissions hack because setfacl does not work on Mac and Windows
	mkdir -p var/cache var/logs var/sessions && chown -R www-data var
fi

exec docker-php-entrypoint "$@"
