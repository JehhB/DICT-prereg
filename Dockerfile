FROM php:8.2.4-apache
RUN a2enmod headers rewrite && docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html
