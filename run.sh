#!/bin/bash

# copy env
cp .env.example .env

# install
composer install

# create database
echo "Creating local database..."
touch database/database.sqlite

# run artisan tools
echo "Running migrations..."
php artisan migrate:fresh --seed
php artisan serve
