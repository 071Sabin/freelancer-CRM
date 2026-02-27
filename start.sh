#!/bin/sh

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
# This is the line that forces the data in
php artisan db:seed --force 

echo "Starting Apache..."
apache2-foreground
