# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/compose/compose-file/#target

ARG PHP_VERSION=7.4-fpm-alpine
ARG NGINX_VERSION=1.19.3-alpine

### NGINX
FROM nginx:${NGINX_VERSION} AS symfony_docker_nginx

COPY docker/nginx/conf.d /etc/nginx/conf.d/
COPY public /srv/app/public/

### PHP
FROM php:${PHP_VERSION} AS symfony_docker_php

RUN apk add --no-cache \
        openssh \
		git \
		icu-libs \
		zlib \
		libzip-dev \
		jq \
	&& mkdir /opt/bin \
    && curl -L https://github.com/a8m/envsubst/releases/download/v1.1.0/envsubst-`uname -s`-`uname -m` -o /opt/bin/envsubst \
    && chmod +x /opt/bin/envsubst

RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony && chmod a+x /usr/local/bin/symfony

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY docker/app/conf.d/symfony.ini $PHP_INI_DIR/conf.d/symfony.ini
COPY docker/app/conf.d/php-fpm.conf.template /usr/local/etc/php-fpm.conf.template
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/app/docker-entrypoint.sh /usr/local/bin/docker-app-entrypoint
RUN chmod +x /usr/local/bin/docker-app-entrypoint

WORKDIR /srv/app
ENTRYPOINT ["docker-app-entrypoint"]
CMD ["php-fpm"]

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

COPY bin ./bin
COPY config ./config
COPY src ./src
COPY public ./public

COPY composer.json ./composer.json
COPY composer.lock ./composer.lock
COPY symfony.lock ./symfony.lock

### DEV BUILD
FROM symfony_docker_php as build_development

COPY vendor ./vendor
COPY .env ./.env

RUN mkdir -p var/cache var/logs var/sessions \
    && composer install --prefer-dist --no-dev --no-scripts --no-progress --classmap-authoritative --no-interaction \
    && composer clear-cache \
    && chown -R www-data var
