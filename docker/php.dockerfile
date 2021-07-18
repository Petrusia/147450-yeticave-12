FROM php:7.4.16-fpm-alpine

RUN mkdir -p /var/www/html

RUN apk --no-cache add shadow && usermod -u 1000 www-data

RUN docker-php-ext-install mysqli pdo pdo_mysql
