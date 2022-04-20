FROM php:8.1.5-fpm-alpine

COPY --from=composer:2.3.5 /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/stargaze
USER root

RUN apk -U --no-cache add \
    autoconf make g++ \
    unzip curl-dev \
    libzip-dev icu-dev libpq-dev zlib-dev

RUN pecl install -f apcu \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install curl intl opcache pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql apcu \
    && pecl clear-cache
