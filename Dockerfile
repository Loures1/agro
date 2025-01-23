FROM php:8.2-apache
WORKDIR /var
RUN sed -i "s|/var/www/html|/var/public/|g" /etc/apache2/sites-available/*.conf && sed -i "s|/var/www/|/var/public/|g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
