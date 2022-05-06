FROM php:8.1.5-fpm-alpine

COPY --from=composer:2.3.5 /usr/bin/composer /usr/local/bin/composer
COPY docker/etc /etc
COPY docker/etc /usr/local/etc

WORKDIR /var/www/stargaze

RUN apk -U add --no-cache \
    nginx \
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

COPY --chown=www-data:www-data . .

RUN composer install --no-dev \
    && composer clearcache

RUN bin/console lexik:jwt:generate-keypair \
    && chmod +x /etc/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/etc/entrypoint.sh"]
