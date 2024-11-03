# Gunakan image dasar PHP dengan varian Alpine yang ringan
FROM php:8.2-fpm-alpine

# Install dependencies dengan memanfaatkan cache
RUN apk update && apk add --no-cache \
    php-mbstring \
    php-xml \
    php-mysqli \
    php-zip \
    php-curl \
    php-bcmath \
    curl \
    unzip \
    git \
    bash \
    libpng-dev \
    oniguruma-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy file composer.json dan composer.lock saja untuk caching dependencies
COPY composer.json composer.lock ./

# Install dependencies Laravel dengan Composer menggunakan cache
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy seluruh project Laravel ke dalam container
COPY . .

# Set permission untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port untuk Laravel
EXPOSE 8000

# Command default untuk menjalankan Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --prefer-dist --optimize-autoloader.