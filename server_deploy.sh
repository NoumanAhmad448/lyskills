#!/bin/bash

# Enable maintenance mode
php artisan down || true

#generate artisan key
php artisan key:generate

# Secure .env and other sensitive files before running anything
chmod 600 /home/nomilyskills/public_html/.env
chmod 600 /home/nomilyskills/public_html/phpunit.xml
chmod 600 /home/nomilyskills/public_html/composer.json
chmod 600 /home/nomilyskills/public_html/composer.lock

chown root:root /home/nomilyskills/public_html/.env
chown root:root /home/nomilyskills/public_html/phpunit.xml
chown root:root /home/nomilyskills/public_html/composer.json
chown root:root /home/nomilyskills/public_html/composer.lock

# Set correct permissions for storage & bootstrap/cache (needed for Laravel)
chmod -R 775 /home/nomilyskills/public_html/storage
chmod -R 775 /home/nomilyskills/public_html/bootstrap/cache
chown -R root:www-data /home/nomilyskills/public_html/storage
chown -R root:www-data /home/nomilyskills/public_html/bootstrap/cache

# Update Composer Dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache

# to avoid any node permission error
chmod -R 777 /home/nomilyskills/public_html/

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run database migrations (ensuring root runs them)
php artisan migrate --force

# Ensure correct Node.js version
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
nvm use 16

# Install Node.js dependencies
npm install

# to avoid any node permission error
chmod -R 777 /home/nomilyskills/public_html/

# Run on production mode
npm run production

# Reset permissions for web server & FTP user after script runs
chown -R nomilyskills:nomilyskills /home/nomilyskills/public_html/
chmod -R 755 /home/nomilyskills/public_html/

# Restore restricted permissions for sensitive files
chmod 600 /home/nomilyskills/public_html/.env
chmod 600 /home/nomilyskills/public_html/phpunit.xml
chmod 600 /home/nomilyskills/public_html/composer.json
chmod 600 /home/nomilyskills/public_html/composer.lock
chown root:root /home/nomilyskills/public_html/.env
chown root:root /home/nomilyskills/public_html/phpunit.xml
chown root:root /home/nomilyskills/public_html/composer.json
chown root:root /home/nomilyskills/public_html/composer.lock


# Disable maintenance mode
php artisan up
