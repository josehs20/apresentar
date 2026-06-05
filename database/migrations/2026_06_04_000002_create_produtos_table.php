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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->text('descricao');
            $table->text('composicao');
            $table->decimal('preco', 10, 2)->nullable();
            $table->string('caminho_imagem')->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('tipo_pele')->nullable();

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
        Schema::dropIfExists('produtos');
    }
};
