# Utilise l'image PHP
FROM php:8.3-fpm

# Installe les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    build-essential \
    autoconf \
    libxml2-dev \
    libtool \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml ctype

# Installe Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Définit le répertoire de travail pour l'application
WORKDIR /app

# Copie tous les fichiers dans le conteneur
COPY . /app

# Donne les permissions pour les répertoires de Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Installe les dépendances Composer
RUN composer install --no-dev --optimize-autoloader

# Expose le port PHP-FPM
EXPOSE 8000

# Commande par défaut
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

