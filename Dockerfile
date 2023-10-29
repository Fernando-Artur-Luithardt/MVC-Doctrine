FROM php:8.1-apache
RUN apt-get update && apt upgrade -y
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Instala o Composer
RUN apt install unzip
RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

ADD ./src /var/www/html
COPY ./src/ /var/www/html
RUN composer install
EXPOSE 80