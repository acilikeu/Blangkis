# Gunakan image resmi PHP + Apache
FROM php:8.1-apache

# Install ekstensi yang diperlukan (termasuk mysqli)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Salin semua file project ke dalam container
COPY . /var/www/html

# Ubah document root ke /var/www/html/public (CodeIgniter pakai folder public)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update apache config agar mengenali folder public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Aktifkan rewrite module
RUN a2enmod rewrite

# Set permission agar folder bisa ditulis (opsional)
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80
