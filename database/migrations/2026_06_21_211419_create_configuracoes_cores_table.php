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
        Schema::create('configuracoes_cores', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color', 7)->default('#76877D');
            $table->string('secondary_color', 7)->default('#96958A');
            $table->string('accent_color', 7)->default('#88B8A9');
            $table->string('border_color', 7)->default('#B2CBAE');
            $table->string('background_color', 7)->default('#F8F6F0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes_cores');
    }
};
