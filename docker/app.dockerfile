FROM php:8.4-fpm-alpine AS app

# Instala dependências do sistema
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
    supervisor \
    gettext \
    nodejs \
    npm

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) \
    gd bcmath pdo_sqlite pdo mbstring zip intl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório da app
WORKDIR /var/www/html

# Copia projeto
COPY . .

# Instala dependências PHP (produção)
RUN composer install --no-dev --optimize-autoloader

# Instala dependências Node e builda assets front-end
RUN npm ci --include=dev && npm run build && rm -rf node_modules

# Produção: cache de configuração
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Cria SQLite + permissões
RUN mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 database storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
