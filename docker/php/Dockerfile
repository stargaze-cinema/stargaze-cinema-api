FROM php:8.1.2-fpm

RUN apt-get update

RUN apt-get install -y libzip-dev libicu-dev libpq-dev \
    zlib1g-dev curl g++ zip \
    && pecl install apcu \
    && docker-php-ext-install zip \
    && docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache \
    && docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-enable apcu pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
