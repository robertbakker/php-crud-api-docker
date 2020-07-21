FROM composer AS composer
COPY composer.* /app/
RUN composer install

FROM php:7.4-apache

RUN apt-get update -y && apt-get -y install \ 
        libpq-dev

RUN docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql

RUN a2enmod rewrite

RUN mkdir /var/www/html/config

COPY config/ /var/www/html/config/
COPY index.php /var/www/html/index.php
COPY .env .env.* /var/www/html/
COPY .htaccess /var/www/html/.htaccess
COPY --from=composer /app/vendor/ /var/www/html/vendor/
