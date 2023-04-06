#!/bin/bash

set -e

exit_with_error() {
  echo "Error: $1"
  exit 1
}

# Check for the --fresh flag
FRESH=false
for arg in "$@"
do
  if [ "$arg" = "--fresh" ]
  then
    FRESH=true
    break
  fi
done

# Check if Docker Compose is running and stop it
if docker-compose -f docker/docker-compose.yml ps | grep -q Up; then
  echo "Stopping running Docker Compose services..."
  docker-compose -f docker/docker-compose.yml down
fi

# Build and run containers
echo "Building and running containers..."
docker-compose -f docker/docker-compose.yml up -d

# Clear Composer cache
echo "Clearing Composer cache..."
docker-compose -f docker/docker-compose.yml exec -T php composer clear-cache

# Install composer dependencies
echo "Installing composer dependencies..."
docker-compose -f docker/docker-compose.yml exec -T php composer install || { echo "Composer install failed."; exit 1; }

# Install npm dependencies
echo "Installing npm dependencies..."
if [ ! -f /var/www/html/package-lock.json ]; then
  docker-compose -f docker/docker-compose.yml exec -T php bash -c "npm install"
fi

docker-compose -f docker/docker-compose.yml exec -T php bash -c "npm ci" || exit_with_error "npm install failed."


# Build npm dependencies
echo "Building npm dependencies..."
docker-compose -f docker/docker-compose.yml exec -T php bash -c "npm run build" || exit_with_error "npm build failed."

# Set folder permissions
echo "Setting folder permissions..."
docker-compose -f docker/docker-compose.yml exec -T php chown -R www-data:www-data /var/www/html/storage || { echo "Setting storage folder permissions failed."; exit 1; }
docker-compose -f docker/docker-compose.yml exec -T php chown -R www-data:www-data /var/www/html/bootstrap/cache || { echo "Setting bootstrap/cache folder permissions failed."; exit 1; }

# Run migrations and seeders based on the flag
if [ "$FRESH" = true ]
then
  echo "Running migrations with fresh and seeders..."
  docker-compose -f docker/docker-compose.yml exec -T php php artisan migrate:fresh --seed || { echo "Migrations with fresh and seeders failed."; exit 1; }
else
  echo "Running migrations..."
  docker-compose -f docker/docker-compose.yml exec -T php php artisan migrate || { echo "Migrations failed."; exit 1; }
fi

echo "All done!"