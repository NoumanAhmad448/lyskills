#!/bin/bash

# Enable maintenance mode
php artisan down || true

mkdir -p /home/nomilyskills/public_html/storage/app 
mkdir -p /home/nomilyskills/public_html/storage/framework/cache
mkdir -p /home/nomilyskills/public_html/storage/framework/sessions 
mkdir -p /home/nomilyskills/public_html/storage/framework/views
mkdir -p /home/nomilyskills/public_html/storage/logs

#generate artisan key
yes | php artisan key:generate

# Secure .env and other sensitive files before running anything
sudo chmod -R 775 /home/nomilyskills/public_html/
sudo chmod 444 /home/nomilyskills/public_html/.env
sudo chown -R root:root /home/nomilyskills/public_html/

# Set correct permissions for storage & bootstrap/cache (needed for Laravel)
yes | chmod -R 777 /home/nomilyskills/public_html/storage/ /home/nomilyskills/public_html/bootstrap/cache

# php version
php --version

# Check if PHP 8.1 is installed
if ! php -v | grep -q "PHP 8.1"; then
  echo "PHP 8.1 is not installed. Exiting."
  exit 1
fi

# Check if Composer is installed, and install it if not
if ! command -v composer &> /dev/null; then
  echo "Composer is not installed. Installing Composer..."
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  php -r "unlink('composer-setup.php');"
else
  echo "Composer is already installed."
  composer --version
fi

# Update Composer Dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache

# to avoid any node permission error
sudo chown -R root:root /home/nomilyskills/public_html/

# Run database migrations (ensuring root runs them)
yes | php artisan migrate --force

# yes | php artisan db:seed --class=LanguageSeeder

# Clear caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear
php artisan view:clear && php artisan event:clear && php artisan clear-compiled
php artisan optimize:clear
php artisan cache:forget spatie.permission.cache


# Check if the version is installed

if [[ $(node -v) == "v20.4"* ]]; then
  echo "Node.js version is v20.4."
else
  echo "Node.js version is NOT v20.4."
  nvm install 20.18.3
fi

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

yes | nvm use 20.18.3


rm -rf node_modules package-lock.json

# Install Node.js dependencies
npm install

npm audit fix --force

# Run on production mode
npm run production

# check project health notification
php artisan health:check --no-notification

# Reset permissions for web server & FTP user after script runs
sudo chown -R nomilyskills:nomilyskills /home/nomilyskills/public_html/
sudo chmod -R 755 /home/nomilyskills/public_html/
sudo chmod 444 /home/nomilyskills/public_html/.env

# Restore restricted permissions for sensitive files
# sudo chmod -R 755  /home/nomilyskills/public_html/server_deploy.sh
# sudo chown -R nomilyskills:nomilyskills /home/nomilyskills/public_html/server_deploy.sh

# runs cron
php artisan schedule:run >> /dev/null 2>&1

# Disable maintenance mode
php artisan up
