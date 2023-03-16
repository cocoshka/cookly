FROM php:8.2.3-fpm-alpine

RUN apk add --update --no-cache linux-headers postgresql-dev $PHPIZE_DEPS

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug
