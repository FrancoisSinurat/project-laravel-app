FROM registry.dcktrp.id/php8.1-oci8-dcktrp:1.0.0

# Increase upload file size
COPY docker/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Add libraries
RUN apk add --no-cache zlib-dev libpng-dev libzip-dev
RUN docker-php-ext-install gd zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Setup application
COPY . /var/www/html

RUN cd /var/www/html && composer install && php artisan migrate:fresh && php artisan db:seed php artisan key:generate

RUN chown -R nginx:nginx /var/www/html/storage
RUN chown -R nginx:nginx /var/www/html/bootstrap/cache

COPY docker/default.conf /etc/nginx/http.d/default.conf
