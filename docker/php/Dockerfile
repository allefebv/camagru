FROM php:7.2-fpm

COPY .          /var/www/html
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY mail.ini /usr/local/etc/php/conf.d/mail.ini
COPY msmtprc /etc/msmtprc

COPY php-entrypoint.sh /usr/local/bin
RUN chmod 777 /usr/local/bin/php-entrypoint.sh


RUN apt-get upgrade && apt-get update \
    && apt-get install -y libpng-dev

RUN docker-php-ext-install pdo pdo_mysql gd
RUN pecl install xdebug 
RUN docker-php-ext-enable xdebug

WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/php-entrypoint.sh"]