# Use PHP 5.6 with Apache as the base image
FROM php:5.6-apache

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Update the apt sources to use the archived Debian repositories
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list

# Fix a missing && after deleting the stretch-updates line
RUN apt-get -o Acquire::Check-Valid-Until=false update && \
    apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo_mysql

# Optionally set the timezone
RUN echo "date.timezone=America/New_York" > /usr/local/etc/php/conf.d/timezone.ini

# Copy application code to the default Apache document root
COPY . /var/www/html/

# Set correct permissions for the tmp directory
RUN chown -R www-data:www-data /var/www/html/app && \
    chmod -R 755 /var/www/html/app

# Add your custom Apache configuration
COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Start Apache in the foreground
CMD ["apache2-foreground"]
