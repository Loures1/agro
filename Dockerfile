FROM php:8.2-apache
RUN a2enmod rewrite
RUN sed -i "s|/var/www/html|/var/public/|g" /etc/apache2/sites-available/*.conf && sed -i "s|/var/www/|/var/public/|g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get install -y libzip-dev=1.7.3-1+b1 && docker-php-ext-install zip
