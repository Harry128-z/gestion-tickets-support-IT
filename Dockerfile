FROM php:8.2-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql gd
COPY . .
RUN chmod -R 777 storage bootstrap/cache
CMD ["php-fpm"]
