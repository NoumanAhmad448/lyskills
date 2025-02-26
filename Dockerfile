# Dockerfile

# Use official PHP image with Nginx
FROM php:8.1-fpm

# Use build argument
ARG APP_ENV

# Set environment variable based on ARG
ENV APP_ENV=${APP_ENV}

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath 
    # gd json mbstring 
    # \
    # openssl     \
    # zip \
    # intl \
    # xml \
    # dom \
    # fileinfo \
    # iconv \
    # simplexml \
    # soap \
    # sockets \
    # tokenizer \
    # zlib
    # curl

# Verify BCMath is enabled
RUN php -m | grep bcmath
# Install Node.js 16 using curl
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /home/nomilyskills/public_html
# Assuming WORKDIR is set previously
RUN mkdir -p ${WORKDIR}/storage/app 
RUN mkdir -p ${WORKDIR}/storage/framework/cache
RUN mkdir -p ${WORKDIR}/storage/framework/sessions 
RUN mkdir -p ${WORKDIR}/storage/framework/views
RUN mkdir -p ${WORKDIR}/storage/logs

# Copy the Laravel application code into the container
COPY . /home/nomilyskills/public_html

# Set the correct permissions for Laravel files
RUN mv .env.dev .env

# Set the correct permissions for Laravel files
RUN if [ "dev" != "dev" ]; then \
    chown -R nomilyskills:nomilyskills /home/nomilyskills/public_html/storage /home/nomilyskills/public_html/bootstrap/cache; \
fi

# Enable maintenance mode
RUN php artisan down || true


RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache

#generate artisan key
RUN yes | php artisan key:generate

# Run database migrations (ensuring root runs them)
RUN php artisan migrate --force

# Clear caches
RUN  php artisan cache:clear
RUN  php artisan config:clear
RUN  php artisan view:clear

# Install Node.js dependencies
RUN npm install


# Run on production mode
RUN npm run production

# check project health notification
RUN php artisan health:check --no-notification

RUN php artisan up

# Expose the port 9000 for PHP-FPM
EXPOSE 9000
