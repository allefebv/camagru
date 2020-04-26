FROM php:7.2-fpm

COPY .          /var/www/html
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug 
RUN docker-php-ext-enable xdebug
RUN apt-get upgrade && apt-get update
RUN apt-get install -y vim

WORKDIR /var/www/html