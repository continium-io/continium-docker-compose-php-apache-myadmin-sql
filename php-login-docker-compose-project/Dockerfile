FROM php:7.2-apache

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN mkdir /app \
 && mkdir /app/continium-php-mysql-compose-demo \
 && mkdir /app/continium-php-mysql-compose-demo/www

COPY www/ /app/continium-php-mysql-compose-demo/www/

RUN cp -r /app/continium-php-mysql-compose-demo/www/* /var/www/html/.
