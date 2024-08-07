FROM php:8.2.4-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    openssl \
    && rm -rf /var/lib/apt/lists/*

# Configure and install GD and ZIP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip

# Enable Apache modules and install PDO extensions
RUN a2enmod headers rewrite ssl \
    && a2ensite default-ssl \
    && docker-php-ext-install pdo pdo_mysql

# Generate a self-signed certificate
RUN mkdir -p /etc/ssl/private /etc/ssl/certs \
    && openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
       -keyout /etc/ssl/private/apache.key \
       -out /etc/ssl/certs/apache.crt \
       -subj "/C=US/ST=State/L=City/O=Organization/OU=Unit/CN=192.168.166.44" \
       -addext "subjectAltName=IP:192.168.166.44, DNS:localhost"

# Configure SSL settings
RUN echo '<VirtualHost *:443>\n\
    SSLEngine on\n\
    SSLCertificateFile /etc/ssl/certs/apache.crt\n\
    SSLCertificateKeyFile /etc/ssl/private/apache.key\n\
    DocumentRoot /var/www/html\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
    </Directory>\n\
    <IfModule mod_rewrite.c>\n\
        RewriteEngine On\n\
        RewriteCond %{HTTPS} !=on\n\
        RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n\
    </IfModule>\n\
</VirtualHost>' > /etc/apache2/sites-available/default-ssl.conf

COPY . /var/www/html

EXPOSE 443
