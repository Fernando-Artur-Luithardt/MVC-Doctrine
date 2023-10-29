FROM php:8.1-apache
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
WORKDIR /var/www
COPY --chown=www-data:www-data . /var/www
EXPOSE 9000
CMD ["php-fpm"]