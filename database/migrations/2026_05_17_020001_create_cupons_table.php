<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cupom', function (Blueprint $table) {
            $table->id('id_cupom');
            $table->string('codigo')->unique();
            $table->unsignedBigInteger('id_promocao');

            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_fim')->nullable();

            $table->unsignedInteger('limite_uso_total')->nullable();
            $table->unsignedInteger('limite_uso_por_usuario')->nullable();

            $table->string('status')->default('ativa'); // ativa/inativa
            $table->timestamps();

            $table->foreign('id_promocao')->references('id_promocao')->on('promocao')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupom');
    }
};

