# Base image
FROM php:8.2-apache

# Install dependency
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip gd

# Enable Apache Rewrite
RUN a2enmod rewrite

# Ubah Apache listen port ke 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Ubah DocumentRoot ke folder public (CI4)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-enabled/000-default.conf

# Copy project ke dalam container
COPY . /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port Railway
EXPOSE 8080

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
