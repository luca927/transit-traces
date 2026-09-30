FROM php:8.2-apache

# Abilita mod_rewrite per Laravel
RUN a2enmod rewrite

# Installa dipendenze per PHP, SQLite, Node.js e npm
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql gd

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html/

# Installa dipendenze PHP (vendor/)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Installa dipendenze JS e compila gli asset grafici (Vite)
RUN npm install && npm run build

# Prepara cartelle e permessi
RUN touch database/database.sqlite \
    && mkdir -p storage/framework/views storage/framework/sessions storage/framework/cache storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 777 storage bootstrap/cache database database/database.sqlite

# Configura Apache su public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Avvio
CMD touch /var/www/html/database/database.sqlite && chmod 777 /var/www/html/database/database.sqlite && php artisan migrate --force && apache2-foreground