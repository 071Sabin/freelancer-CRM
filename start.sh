#!/bin/bash

# 1. Always run migrations to keep the database schema up to date
echo "Running migrations..."
php artisan migrate --force

# 2. Only run seeders if we explicitly tell it to via Render environment variables
if [ "$RUN_SEEDERS" = "true" ]; then
    echo "Running seeders..."
    php artisan db:seed --force
fi

# 3. Start Apache to serve the application
echo "Starting Apache..."
apache2-foreground
