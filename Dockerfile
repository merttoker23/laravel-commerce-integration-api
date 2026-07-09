FROM php:8.2-fpm-alpine

RUN apk add --no-cache bash git curl unzip icu-dev oniguruma-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip mbstring

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
CMD ["php-fpm"]
