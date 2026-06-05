<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postagens', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('resumo');
            $table->longText('conteudo');
            $table->string('caminho_imagem')->nullable();
            $table->timestamp('publicado_em')->nullable();

            // SEO
            $table->string('meta_titulo')->nullable();
            $table->text('meta_descricao')->nullable();
            $table->string('meta_imagem')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postagens');
    }
};
