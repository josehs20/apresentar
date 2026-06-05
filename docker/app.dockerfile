FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zlib-dev \
    icu-dev \
    sqlite-dev \
    oniguruma-dev \
    libzip-dev \
    shadow

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd bcmath pdo_sqlite pdo mbstring zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/html
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]
