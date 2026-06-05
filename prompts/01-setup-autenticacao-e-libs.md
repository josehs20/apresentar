# Contexto: Setup Inicial e Autenticação

Com o ambiente Docker rodando (PHP 8.4), precisamos inicializar o projeto Laravel (^13.8) e configurar a base do painel administrativo.

# Bibliotecas Escolhidas

* **Autenticação e Layout Base:** Laravel Breeze (Blade stack com bootstrap CSS).
* **Processamento de Imagens:** Intervention Image v3 (driver GD).

# Tarefa

1. Inicialize um novo projeto Laravel garantindo as versões especificadas no `composer.json` (`"php": "^8.4"`, `"laravel/framework": "^13.8"`).
2. Configure o arquivo `.env` para usar o driver `sqlite` (`DB_CONNECTION=sqlite`) e certifique-se de que o arquivo `database/database.sqlite` seja criado.
3. Instale o pacote `laravel/breeze` usando a stack padrão (Blade) para gerar o sistema de login, registro e o layout base do Dashboard.
4. Instale o pacote `intervention/image` (v3) via Composer e publique as configurações dele.
5. Garanta que o comando `php artisan storage:link` seja executado no setup para que as pastas de imagens fiquem acessíveis publicamente.

# Configuração de Filas (OBRIGATÓRIO)

1. Configure no `.env`:
   QUEUE_CONNECTION=database

2. Gere a tabela de filas:
   php artisan queue:table
   php artisan migrate

3. O worker deve ser executado em background:
   php artisan queue:work

# Regras

* Mantenha o layout do Breeze limpo, usaremos ele como base para o nosso painel Admin nos próximos passos.
* O registro de novos usuários (`/register`) deve ser desativado ou bloqueado nas rotas após a criação do primeiro usuário administrador via seeder.
