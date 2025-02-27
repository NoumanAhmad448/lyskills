# Turn on maintenance mode
php artisan down || true

# Install/update composer dependecies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache

# Clear caches
php artisan cache:clear

# Run database migrations
php artisan migrate --force

#generate artisan key
php artisan key:generate

# change folder permission
chmod -R 777 /home/nomilyskills/public_html/

# change folder permission
sudo chown  root:root /home/nomilyskills/public_html/

# change node permission
sudo ln -sf $(which node) /usr/bin/node
sudo chmod +x $(which node)

# Redisplay the maintenance mode message
ls -lah $(which node)

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache

# set the right version of node
nvm use 16

# Install node modules
npm install

# Build assets using Laravel Mix
npm run production

# clear permission
sudo chown nomilyskills:nomilyskills /home/nomilyskills/public_html/
sudo chown root:root  .env phpunit.xml php.ini server_deploy.sh .htaccess artisan composer.json composer.lock package.json webpack.mix.js

# Turn off maintenance mode
php artisan up