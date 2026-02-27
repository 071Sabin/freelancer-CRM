FROM php:8.2-apache

RUN apt-get update && apt-get install -y libpq-dev libpng-dev libonig-dev libxml2-dev zip unzip git curl nodejs npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Enable Apache rewrite
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader
# Install JS deps and build Vite
RUN npm install
RUN npm run build

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
RUN php artisan storage:link

# Copy the script
COPY start.sh /usr/local/bin/start.sh

# THIS IS CRITICAL: Strip Windows line endings so Linux doesn't choke
RUN sed -i -e 's/\r$//' /usr/local/bin/start.sh

# Make it executable
RUN chmod +x /usr/local/bin/start.sh

# Tell Docker to run the script
CMD ["/usr/local/bin/start.sh"]

# CMD php artisan migrate --force && apache2-foreground
CMD apache2-foreground
