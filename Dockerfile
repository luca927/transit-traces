FROM php:8.2-apache

# Abilita mod_rewrite per Laravel
RUN a2enmod rewrite

# Installa dipendenze di sistema e estensioni PHP
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-install pdo pdo_mysql gd

# Scarica ed installa Composer dentro il container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la cartella di lavoro
WORKDIR /var/www/html

# Copia i file del progetto
COPY . /var/www/html/

# Installa le dipendenze PHP (crea la cartella vendor/)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Configura la cartella public per Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Imposta i permessi corretti per Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

EXPOSE 80