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
        Schema::create('interacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')
                ->nullable()
                ->constrained('produtos')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('tipo_interacao_id')
                ->constrained('tipo_interacoes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('ip', 45);
            $table->text('user_agent');
            $table->timestamp('criado_em')->useCurrent();

            $table->index('produto_id');
            $table->index('tipo_interacao_id');
            $table->index('criado_em');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interacoes');
    }
};
