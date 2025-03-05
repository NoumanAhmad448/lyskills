#!/bin/bash

# Function to install Docker
install_docker() {
    echo "Installing Docker..."

    # Update system packages
    sudo apt-get update -y

    # Install required dependencies
    sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common

    # Add Docker GPG key
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

    # Add Docker repository
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

    # Update package list again
    sudo apt-get update -y

    # Install Docker
    sudo apt-get install -y docker-ce docker-ce-cli containerd.io

    # Enable and start Docker service
    sudo systemctl enable docker
    sudo systemctl start docker

    echo "Docker installation completed!"
}

# Function to check if Docker is installed
check_docker() {
    if command -v docker &> /dev/null; then
        DOCKER_VERSION=$(docker --version | awk '{print $3}' | sed 's/,//')
        echo "✅ Docker is already installed. Version: $DOCKER_VERSION"
    else
        echo "❌ Docker is NOT installed!"
        install_docker
    fi
}

# Function to install Docker Compose
install_docker_compose() {
    echo "Installing Docker Compose..."
    sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
    echo "✅ Docker Compose installed successfully!"
}

# Function to check if Docker Compose is installed
check_docker_compose() {
    if command -v docker-compose &> /dev/null; then
        echo "✅ Docker Compose is already installed."
    else
        echo "❌ Docker Compose is NOT installed!"
        install_docker_compose
        yes | sudo service docker restart
        yes | sudo /etc/init.d/docker restart
        yes | sudo snap restart docker
    fi
}

# Run the check function
check_docker
check_docker_compose

# Load environment variables from .env file
if [ -f .env ]; then
    source .env
else
    echo "❌ .env file not found!"
    exit 1
fi

sudo chmod -R 775 /home/nomilyskills/public_html/
sudo chown -R root:root /home/nomilyskills/public_html/

# Set the environment for your Laravel app (or adjust for other apps)
CONTAINER_NAME="${APP_NAME}-app"
NGINX_CONTAINER_NAME="${APP_NAME}-nginx"
NETWORK_CONTAINER_NAME="${APP_NAME}-network"
NODE_CONTAINER_NAME="${APP_NAME}-node"

# Step 1: Stop and remove the running containers
echo "Stopping and removing the containers..."
docker compose down

# Step 2: Rebuild the Docker containers (to apply any changes in Dockerfile or docker-compose)
echo "Rebuilding Docker containers..."
docker compose build #Required only first time add --no-cache

# Step 3: Bring up the containers again (detached mode)
echo "Starting the containers..."
docker compose up -d

# Enable maintenance mode
docker compose exec $CONTAINER_NAME php artisan down || true


docker compose exec $CONTAINER_NAME composer install --no-interaction --prefer-dist --optimize-autoloader --no-cache

#generate artisan key
docker compose exec $CONTAINER_NAME yes | php artisan key:generate

# checking docker container
docker ps

# Run database migrations (ensuring root runs them)
sleep 10 && docker compose exec $CONTAINER_NAME php artisan migrate --force

# Step 4: Clear Laravel caches (or any other app-related cache clearing command)
echo "Clearing Laravel caches..."
docker compose exec $CONTAINER_NAME php artisan config:clear
docker compose exec $CONTAINER_NAME php artisan cache:clear
docker compose exec $CONTAINER_NAME php artisan view:clear
docker compose exec $CONTAINER_NAME php artisan route:clear
docker compose exec $CONTAINER_NAME php artisan optimize:clear

# Node Versions
docker compose exec $CONTAINER_NAME npm --version
docker compose exec $CONTAINER_NAME node --version

# Install Node.js dependencies
docker compose exec $CONTAINER_NAME npm install

docker compose exec $CONTAINER_NAME npm audit fix || true

# Run on production mode
docker compose exec $CONTAINER_NAME npm run production

# check project health notification
docker compose exec $CONTAINER_NAME php artisan health:check --no-notification

docker compose exec $CONTAINER_NAME APP_ENV=testing php artisan test --filter EnvFilesConsistencyTest

docker compose exec $CONTAINER_NAME php artisan schedule:run >> /dev/null 2>&1

docker compose exec $CONTAINER_NAME php artisan up

# Step 5: Reload Nginx to apply any config changes (if using Nginx)
echo "Reloading Nginx..."
docker compose exec $NGINX_CONTAINER_NAME nginx -s reload

# Step 7: Verify the sync between host and container (if using volumes)
echo "Verifying that volumes are synced..."
docker compose exec $CONTAINER_NAME ls -l /var/www/html

# Step 8: Verifying the docker
docker ps

if [ "$APP_ENV" != 'production' ]; then
    # For troubleshooting
    docker network inspect $NETWORK_CONTAINER_NAME

    docker compose exec $CONTAINER_NAME netstat -tulpn | grep php-fpm

    docker compose exec $CONTAINER_NAME cat /usr/local/etc/php-fpm.d/www.conf | grep "listen"
fi

echo "$DOCKER_PASS" | docker login -u "$DOCKER_USER" --password-stdin
docker compose push $CONTAINER_NAME

# Logout for security
echo "Logging out from Docker Hub..."
docker logout

echo "All done! Your Docker containers are up and running with the latest changes."