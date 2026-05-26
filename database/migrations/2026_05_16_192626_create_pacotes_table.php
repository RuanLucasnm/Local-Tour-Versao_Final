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
        Schema::create('pacote', function (Blueprint $table) {
            $table->id('id_pacote');
            $table->unsignedBigInteger('id_cidade');
            $table->unsignedBigInteger('id_transporte');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->text('roteiro')->nullable();
            $table->decimal('preco', 10, 2);
            $table->timestamps();

            $table->foreign('id_cidade')->references('id_cidade')->on('cidade');
            $table->foreign('id_transporte')->references('id_transporte')->on('transporte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacotes');
    }
};
