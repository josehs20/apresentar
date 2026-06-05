FROM php:8.2-fpm-alpine

# Instala dependências
RUN apk add --no-cache \
    nginx \
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
    supervisor

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

# Instala dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# 🔥 LIMPA CACHE (COLOQUE AQUI)
RUN php artisan config:clear \
 && php artisan cache:clear \
 && php artisan route:clear \
 && php artisan view:clear

# 🔥 Cria SQLite + permissões
RUN mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 database storage bootstrap/cache

# (opcional depois que tudo estiver ok)
# RUN php artisan config:cache
# RUN php artisan route:cache

# Configuração do Nginx
RUN rm -rf /etc/nginx/http.d/default.conf
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Configuração do Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Porta Railway
EXPOSE 8080
ENV PORT=8080
# Start
CMD sh -c "envsubst '\$PORT' < /etc/nginx/http.d/default.conf > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"