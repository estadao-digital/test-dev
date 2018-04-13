#!/bin/bash

echo "Uploading Application container"
docker-compose up -d

echo "Copying the configuration example file"
docker exec -it web_container cp .env.example .env

echo "Install dependencies"
docker exec -it web_container composer install

echo "Generate key"
docker exec -it web_container php artisan key:generate

echo "Make migrations"
docker exec -it web_container php artisan migrate

echo "Make seeds"
docker exec -it web_container php artisan db:seed

echo "Listing Routes"
docker exec -it web_container php artisan route:list

echo "Information of new containers"
docker ps -a