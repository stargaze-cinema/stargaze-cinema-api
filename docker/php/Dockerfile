FROM php:8.1.3-fpm-alpine

RUN apk update && apk --no-cache add autoconf make g++

RUN apk add --no-cache unzip curl-dev \
    libzip-dev icu-dev libpq-dev zlib-dev

RUN pecl install apcu \
    && docker-php-ext-enable apcu \
    && pecl clear-cache

RUN docker-php-ext-install curl

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache

RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql

WORKDIR /var/www/stargaze

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN rm -rf /tmp/* /var/tmp/*
