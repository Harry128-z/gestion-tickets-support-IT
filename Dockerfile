# Étape 1 : Utiliser une image PHP avec Composer
FROM composer:latest AS composer

# Copier les fichiers du projet
WORKDIR /app
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Étape 2 : Utiliser une image PHP-FPM
FROM php:8.2-fpm

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Copier les fichiers depuis l'étape Composer
COPY --from=composer /app /var/www

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Définir le répertoire de travail
WORKDIR /var/www

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]