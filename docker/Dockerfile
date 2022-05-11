FROM composer:2.3.5 AS build

WORKDIR /build

COPY composer.* symfony.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

COPY . .

RUN composer dump-autoload --optimize

FROM php:8.1.5-fpm-alpine3.15 AS production

WORKDIR /var/www/stargaze

RUN apk -U add --no-cache \
    nginx \
    autoconf make g++ \
    unzip curl-dev \
    libzip-dev icu-dev libpq-dev zlib-dev

RUN pecl install -f apcu-5.1.21 \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install curl intl opcache pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql apcu \
    && pecl clear-cache

COPY docker/etc /etc

ARG S6_OVERLAY_VERSION=v3.1.0.1
RUN S6_OVERLAY_RELEASES=https://github.com/just-containers/s6-overlay/releases/download \
    && curl -sSL $S6_OVERLAY_RELEASES/${S6_OVERLAY_VERSION}/s6-overlay-noarch.tar.xz | tar Jxpf - -C / \
    && curl -sSL $S6_OVERLAY_RELEASES/${S6_OVERLAY_VERSION}/s6-overlay-x86_64.tar.xz | tar Jxpf - -C / \
    && chmod -R +x /etc/cont-init.d /etc/services.d
ENV S6_CMD_WAIT_FOR_SERVICES_MAXTIME=60000

COPY --from=build --chown=www-data:www-data /build .

EXPOSE 80
ENTRYPOINT ["/init"]

FROM production AS development

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=build /usr/bin/composer /usr/local/bin/composer

RUN composer install
