FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libonig-dev libicu-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip gd

# Enable Apache Rewrite + set ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite

# Set Apache to use port 8080 and public folder as root
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-enabled/000-default.conf

# Set working directory ke root project (harus di sini untuk composer install)
WORKDIR /var/www/html

# Copy semua file ke container
COPY . /var/www/html

# Set permission untuk folder writable
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port
EXPOSE 8080

# Jalankan Apache
CMD ["apache2-foreground"]
