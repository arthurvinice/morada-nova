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
        Schema::create('changelog', function (Blueprint $table) {
            $table->id();
            $table->string('versao')->unique();
            $table->date('data_lancamento')->nullable(); //campo só pra os que ja existem
            $table->json('categorias')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('changelog');
    }
};
