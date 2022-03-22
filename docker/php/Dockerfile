FROM php:8.1.4-fpm-alpine
LABEL version="1.3" \
    author="Paul Litovka" \
    description="PHP8.1 FPM Alpine image for Stargaze Cinema project."
WORKDIR /var/www/stargaze
USER root

RUN apk update && apk --no-cache add \
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

RUN docker-php-ext-install curl \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql

RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer
