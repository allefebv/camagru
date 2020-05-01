FROM php:7.2-fpm

COPY .          /var/www/html
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get upgrade && apt-get update && apt-get install -y libpng-dev
RUN docker-php-ext-install pdo pdo_mysql gd
RUN pecl install xdebug 
RUN docker-php-ext-enable xdebug

WORKDIR /var/www/html