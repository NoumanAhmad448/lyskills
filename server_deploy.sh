#!/bin/bash

# Enable maintenance mode
php artisan down || true

#generate artisan key
yes | php artisan key:generate

# Secure .env and other sensitive files before running anything
sudo chmod -R 775 /home/nomilyskills/public_html/
sudo chmod 444 /home/nomilyskills/public_html/.env
sudo chown -R root:root /home/nomilyskills/public_html/

# Set correct permissions for storage & bootstrap/cache (needed for Laravel)
yes | chmod -R 777 /home/nomilyskills/public_html/storage/ /home/nomilyskills/public_html/bootstrap/cache

# Update Composer Dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache

# to avoid any node permission error
sudo chown -R root:root /home/nomilyskills/public_html/

# Run database migrations (ensuring root runs them)
php artisan migrate --force

# yes | php artisan db:seed --class=LanguageSeeder

# Clear caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear
php artisan view:clear && php artisan event:clear && php artisan clear-compiled
php artisan optimize:clear
php artisan cache:forget spatie.permission.cache



# Ensure correct Node.js version
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
nvm use 16

# Install Node.js dependencies
npm install


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
