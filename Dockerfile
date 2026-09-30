FROM php:8.2-apache

# Abilita mod_rewrite per Laravel
RUN a2enmod rewrite

# Installa estensioni necessarie per PHP/MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-install pdo pdo_mysql gd

# Copia i file della webapp nella cartella di Apache
COPY . /var/www/html/

# Configura la cartella public se è Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Imposta i permessi per Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

EXPOSE 80