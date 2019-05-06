FROM php:7.2-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apachectl restart
COPY ./Content/ /var/www/html/
