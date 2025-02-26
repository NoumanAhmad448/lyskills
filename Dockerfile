# Dockerfile

# Use official PHP image with Nginx
FROM php:8.1-fpm

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /home/nomilyskills/public_html

# Copy the Laravel application code into the container
COPY . /home/nomilyskills/public_html

# Set the correct permissions for Laravel files
RUN mv .env.dev .env


# Set the correct permissions for Laravel files
RUN chown -R nomilyskills:nomilyskills /home/nomilyskills/public_html/storage /home/nomilyskills/public_html/bootstrap/cache

# Expose the port 9000 for PHP-FPM
EXPOSE 9000
