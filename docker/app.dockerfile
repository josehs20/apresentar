FROM php:8.4-fpm-alpine

# Instala dependências (removido nginx e supervisor - desnecessários)
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
    gettext

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

# Instala dependências Laravel (útil para cache de imagem, mas entrypoint garante caso volume sobrescreva)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Cria diretórios necessários com permissões
RUN mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache database

# Torna o entrypoint executável
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Entrypoint que gerencia migrações, cache e permissões em runtime
ENTRYPOINT ["docker-entrypoint.sh"]