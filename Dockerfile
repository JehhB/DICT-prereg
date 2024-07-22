FROM php:8.2.4-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && rm -rf /var/lib/apt/lists/*

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Enable Apache modules and install PDO extensions
RUN a2enmod headers rewrite \
    && docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html
