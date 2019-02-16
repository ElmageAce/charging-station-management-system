#!/bin/bash


# Create valid .env file
cp -rf .env.docker .env

cd laradock

# Run containers
docker-compose up -d nginx mariadb phpmyadmin redis workspace elasticsearch

# Run composer install and migrate the database
docker-compose exec workspace bash -c "composer install"
docker-compose exec workspace bash -c "php artisan optimize"
docker-compose exec workspace bash -c "php artisan migrate"

# Install npm and prepare for production
docker-compose exec workspace bash -c "npm install"
docker-compose exec workspace bash -c "npm run prod"

cd ..
