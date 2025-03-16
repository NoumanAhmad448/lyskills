# Dockerfile

# Use official PHP image with Nginx
FROM php:8.1-fpm

# Use build argument
ARG APP_ENV

# Set environment variable based on ARG
ENV APP_ENV=${APP_ENV}
ENV COMPOSER_PROCESS_TIMEOUT=600

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# git nano procps net-tools iproute2
# include the above packages if needed

# Install Node.js 20.x (direct method without NVM)
# Set environment variables for NVM
ENV NVM_DIR="/root/.nvm"

# Install NVM
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash

# Load NVM and install Node.js
RUN bash -c "source $NVM_DIR/nvm.sh && \
    nvm install 20.18.3 && \
    nvm use 20.18.3 && \
    nvm alias default 20.18.3"

# Ensure Node.js and npm are accessible
ENV PATH="$NVM_DIR/versions/node/v20.18.3/bin:$PATH"

# Verify installation
RUN node -v && npm -v

# Verify BCMath is enabled
# RUN php -m | grep bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html
# for development
# RUN git config --global --add safe.directory /var/www/html
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
RUN yes | chmod -R 777 ${WORKDIR}/storage/ ${WORKDIR}/bootstrap/cache


RUN whoami

# enlist the irectory
RUN ls -la ${WORKDIR}

# Set the correct permissions for Laravel files
RUN chown -R $(whoami):$(whoami) /var/www/html/
RUN php artisan key:generate

RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:clear
RUN php artisan optimize:clear


RUN if [$APP_ENV == 'dev']; then npm install ;fi
RUN if [$APP_ENV == 'dev']; then composer install ;fi
RUN if [$APP_ENV == 'dev']; then php artisan migrate ;fi

# Expose the port 9000 for PHP-FPM
EXPOSE 9000
