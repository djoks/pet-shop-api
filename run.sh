#!/bin/bash

set -e

# Define colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

exit_with_error() {
  echo -e "${RED}Error: $1${NC}"
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
  echo -e "${GREEN}1. Stopping running docker-compose services...${NC}"
  docker-compose -f docker/docker-compose.yml down
fi

# Build and run containers
echo -e "${GREEN}\n2. Building and running containers...\n${NC}"
docker-compose -f docker/docker-compose.yml up -d

# Clear Composer cache
echo -e "${GREEN}\n3. Clearing composer cache...\n${NC}"
docker-compose -f docker/docker-compose.yml exec -T php composer clear-cache

# Install composer dependencies
echo -e "${GREEN}\n4. Installing composer dependencies...\n${NC}"
docker-compose -f docker/docker-compose.yml exec -T php composer install || exit_with_error "Composer install failed."

# Install npm dependencies
echo -e "${GREEN}\n5. Installing npm dependencies...\n${NC}"
if [ ! -f /var/www/html/package-lock.json ]; then
  docker-compose -f docker/docker-compose.yml exec -T php bash -c "npm install"
fi

docker-compose -f docker/docker-compose.yml exec -T php bash -c "npm ci" || exit_with_error "npm install failed."


# Build npm dependencies
echo -e "${GREEN}\n6. Building npm dependencies...\n${NC}"
docker-compose -f docker/docker-compose.yml exec -T php bash -c "npm run build" || exit_with_error "npm build failed."

# Set folder permissions
echo -e "${GREEN}\n7. Setting folder permissions...\n${NC}"
docker-compose -f docker/docker-compose.yml exec -T php chown -R www-data:www-data /var/www/html/storage || exit_with_error "Setting storage folder permissions failed."
docker-compose -f docker/docker-compose.yml exec -T php chown -R www-data:www-data /var/www/html/bootstrap/cache || exit_with_error "Setting bootstrap/cache folder permissions failed."

# Run migrations and seeders based on the flag
if [ "$FRESH" = true ]
then
  echo -e "${GREEN}\n8. Running fresh migrations with seeders...\n${NC}"
  docker-compose -f docker/docker-compose.yml exec -T php php artisan migrate:fresh --seed || exit_with_error "Migrations with fresh and seeders failed."
else
  echo -e "${GREEN}\n8. Running migrations...\n${NC}"
  docker-compose -f docker/docker-compose.yml exec -T php php artisan migrate || exit_with_error "Migrations failed."
fi

# Run php artisan storage:link if the directory hasn't already been linked
if docker-compose -f docker/docker-compose.yml exec -T php test ! -L /var/www/html/public/storage; then
  echo -e "${GREEN}\n9. Creating storage symlink...\n${NC}"
  docker-compose -f docker/docker-compose.yml exec -T php php artisan storage:link || exit_with_error "Creating storage symlink failed."
else
  echo -e "${YELLOW}\n9. Storage symlink already exists.\n${NC}"
fi

# Create SQLite database file if it doesn't exist
if [ ! -f database/database.sqlite ]
then 
  docker-compose -f docker/docker-compose.yml exec -T php touch database/database.sqlite
fi

# Generate private and public keys
echo -e "${GREEN}\n10. Generating RSA key...\n${NC}"
if [ ! -f "storage/app/private_key.pem" ]; then
  docker-compose -f docker/docker-compose.yml exec -T php openssl genpkey -algorithm RSA -out storage/app/private_key.pem -pkeyopt rsa_keygen_bits:2048
fi

if [ ! -f "storage/app/public_key.pem" ]; then
  docker-compose -f docker/docker-compose.yml exec -T php openssl rsa -in storage/app/private_key.pem -pubout -out storage/app/public_key.pem
fi

# Change ownership & set permissions
docker-compose -f docker/docker-compose.yml exec -T php chown -R www-data:www-data storage/app/private_key.pem storage/app/public_key.pem
docker-compose -f docker/docker-compose.yml exec -T php chmod 600 storage/app/private_key.pem storage/app/public_key.pem

echo -e "${GREEN}\nAll done!\n${NC}"