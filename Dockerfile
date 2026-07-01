FROM php:8.2-cli

# working directory
WORKDIR /var/www/html

# system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libonig-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# permissions fix
RUN chmod -R 775 storage bootstrap/cache

# Laravel optimization (safe)
RUN php artisan config:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# port for Render
EXPOSE 10000

# start server
CMD php artisan serve --host=0.0.0.0 --port=10000