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

# Function to check if nvm is installed

RUN  echo "Installing nvm..."
RUN  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash
  RUN export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" \
  [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
  RUN echo "nvm installed successfully."


RUN  export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" \
  [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
RUN echo "nvm loaded successfully."


# Main script logic
RUN  nvm --version

RUN export NVM_DIR="$HOME/.nvm"
RUN [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

# Check if the correct Node.js version is installed
RUN echo "Node.js version is NOT v20.18.3. Installing..."
RUN  nvm install 20.18.3


# Use the correct Node.js version
RUN nvm use 20.18.3

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git nano procps net-tools iproute2\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath

# Verify BCMath is enabled
RUN php -m | grep bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

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

# Expose the port 9000 for PHP-FPM
EXPOSE 9000
