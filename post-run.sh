#!/bin/bash

echo running post install scripts for API.......;

cd /var/www/api

cp .env.example .env

composer install --ignore-platform-reqs