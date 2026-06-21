<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pontos_venda', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('endereco')->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('estado', 50)->nullable();
            $table->string('telefone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('horario_funcionamento')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pontos_venda');
    }
};