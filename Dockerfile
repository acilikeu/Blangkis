FROM php:8.2-apache

# Install dependencies & ekstensi tambahan (intl, gd)
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip libpng-dev libjpeg-dev libfreetype6-dev libicu-dev g++ \
    && docker-php-ext-install zip pdo pdo_mysql intl gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy all project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permission
RUN chown -R www-data:www-data /var/www/html

# Apache config
EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Use public folder as DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-enabled/000-default.conf

CMD ["apache2-foreground"]
