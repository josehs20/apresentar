# Contexto: Ambiente e Docker
Estamos criando um site institucional e blog para a marca de cosméticos artesanais "Terra Mar Artesanal". O sistema usará arquitetura MVC padrão. Precisamos de um ambiente Docker extremamente leve para produção.

# Stack de Versões Obrigatória
- PHP: ^8.4
- Laravel Framework: ^13.8
- Laravel Tinker: ^3.0

# Decisão Arquitetural
Para manter a infraestrutura minimalista e reduzir o consumo de RAM, **não usaremos um container de banco de dados externo**. O banco de dados será o SQLite, armazenado no próprio repositório/volume.

# Tarefa
1. Crie um arquivo `docker-compose.yml` contendo apenas os serviços: `app` (PHP-FPM) e `web` (Nginx).
2. Crie a pasta `docker/` na raiz do projeto com os arquivos necessários.
3. Crie um `app.dockerfile` usando uma imagem Alpine do PHP 8.4 FPM (`php:8.4-fpm-alpine`).
   - Inclua apenas as extensões essenciais para o Laravel e para manipulação de imagens (GD, bcmath, pdo_sqlite, mbstring).
   - Configure permissões adequadas para o usuário `www-data`.
4. Crie um `nginx.conf` configurado para direcionar o tráfego para a porta 9000 do container PHP.

# Regras
- Foque em imagens base `alpine` para manter o tamanho reduzido.
- Configure um volume para o diretório `database/` para persistir o banco SQLite.
- A pasta `storage/app/public` do Laravel deve ter um bind de volume para não perdermos as imagens de upload ao recriar os containers.