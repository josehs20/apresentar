#!/bin/sh
set -e

cd /var/www/html

# 🔥 PRIMEIRO: limpa qualquer cache corrompido (caminhos absolutos de outro ambiente)
echo ">>> Limpando caches..."
rm -f bootstrap/cache/config.php bootstrap/cache/routes-v7.php bootstrap/cache/packages.php bootstrap/cache/services.php
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Aguarda o banco SQLite existir
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite

# Instala dependências do Composer se vendor não existir
if [ ! -d "/var/www/html/vendor" ]; then
    echo ">>> Instalando dependências do Composer..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Gera APP_KEY se não existir
php artisan key:generate --force

# Executa as migrações (com tolerância a falha - não quebra o entrypoint)
echo ">>> Executando migrações..."
php artisan migrate --force 2>&1 || echo ">>> (aviso) Migrate falhou, mas continuando..."

# Otimiza cache (se falhar, não trava)
echo ">>> Otimizando cache..."
php artisan config:cache 2>/dev/null || php artisan config:clear
php artisan route:cache 2>/dev/null || php artisan route:clear
php artisan view:cache 2>/dev/null || php artisan view:clear

# Ajusta permissões
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database 2>/dev/null || true

echo ">>> Entrypoint concluído. Iniciando PHP-FPM..."

# Inicia o PHP-FPM em foreground
exec php-fpm