# Dockerfile

# Use official PHP image with Nginx
FROM php:8.1-fpm

# Use build argument
ARG APP_ENV

# Set environment variable based on ARG
ENV APP_ENV=${APP_ENV}
ENV COMPOSER_PROCESS_TIMEOUT=600

# Install necessary PHP extensions
# git nano procps net-tools iproute2
# include the above packages if needed

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git nano procps net-tools iproute2\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath

# Verify BCMath is enabled
RUN php -m | grep bcmath

# Install Node.js 16 using curl
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html
# for development
RUN git config --global --add safe.directory /var/www/html
RUN chmod -R 775 /var/www/html/

# Copy the Laravel application code into the container
COPY . .

# Assuming WORKDIR is set previously
RUN mkdir -p ${WORKDIR}/storage/app
RUN mkdir -p ${WORKDIR}/storage/framework/cache
RUN mkdir -p ${WORKDIR}/storage/framework/sessions
RUN mkdir -p ${WORKDIR}/storage/framework/views
RUN mkdir -p ${WORKDIR}/storage/logs
RUN mkdir -p ${WORKDIR}/bootstrap/cache


# Set the correct permissions for Laravel files
# RUN mv .env.dev .env

RUN whoami

# enlist the irectory
RUN ls -la ${WORKDIR}

# Set the correct permissions for Laravel files
RUN chown -R $(whoami):$(whoami) /var/www/html/


# Enable maintenance mode
RUN php artisan down || true


RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-cache

#generate artisan key
RUN yes | php artisan key:generate


# Run database migrations (ensuring root runs them)
# RUN php artisan migrate --force

# Clear caches
RUN php artisan cache:clear && php artisan config:clear && php artisan route:clear && \
    php artisan view:clear && php artisan event:clear && php artisan clear-compiled && \
    php artisan optimize:clear && \
    php artisan cache:forget spatie.permission.cache

# Node Versions
RUN npm --version
RUN node --version

# Install Node.js dependencies
RUN npm install

# RUN npm audit fix

# Run on production mode
RUN npm run production

# check project health notification
RUN php artisan health:check --no-notification
# RUN APP_ENV=testing php artisan test --filter EnvFilesConsistencyTest

RUN php artisan schedule:run >> /dev/null 2>&1

RUN php artisan up

# Expose the port 9000 for PHP-FPM
EXPOSE 9000
