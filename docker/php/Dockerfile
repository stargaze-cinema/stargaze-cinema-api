FROM php:8.1.3-fpm-alpine

RUN apk update && apk add autoconf make g++

RUN apk add libzip-dev icu-dev libpq-dev zlib-dev curl-dev \
    && pecl install apcu \
    && docker-php-ext-install curl \
    && docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache \
    && docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-enable apcu pdo_pgsql \
    && rm -rf /tmp/* /var/tmp/*

WORKDIR /var/www/stargaze

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
