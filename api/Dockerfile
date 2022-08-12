FROM php:7.0-apache

RUN apt-get update && apt-get install -y libpq-dev

RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug

RUN docker-php-ext-install pgsql pdo pdo_mysql pdo_pgsql

RUN rm -rf /var/log/apache2/access.log

COPY config/php.ini /usr/local/etc/php/
COPY config/config.conf /etc/apache2/conf-available/config.conf

RUN a2enmod rewrite
RUN a2enconf config

COPY . /var/www/html/
RUN rm -rf /var/www/html/temp
RUN rm -rf /var/www/html/config/*
RUN rmdir /var/www/html/config

RUN mkdir /var/www/html/temp
RUN mkdir -p /var/www/html/temp
RUN chmod 777 /var/www/html/temp
