<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Cria o primeiro usuário administrador do painel.
 *
 * As credenciais são lidas a partir do arquivo .env quando definidas:
 *  - ADMIN_NAME
 *  - ADMIN_EMAIL
 *  - ADMIN_PASSWORD
 *
 * Se o arquivo .env não fornecer estes valores, serão utilizados
 * os defaults abaixo, que devem ser trocados assim que possível.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::query()->exists()) {
            $this->command?->warn('AdminUserSeeder: já existem usuários no banco, seeder ignorado.');

            return;
        }

        User::query()->create([
            'name'     => env('ADMIN_NAME', 'Administrador'),
            'email'    => env('ADMIN_EMAIL', 'admin@admin.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);

        $this->command?->info('AdminUserSeeder: usuário administrador criado.');
    }
}
