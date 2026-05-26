<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cupom_pacote', function (Blueprint $table) {
            $table->id('id_cupom_pacote');
            $table->unsignedBigInteger('id_cupom');
            $table->unsignedBigInteger('id_pacote');
            $table->timestamps();

            $table->unique(['id_cupom', 'id_pacote']);

            $table->foreign('id_cupom')->references('id_cupom')->on('cupom')->onDelete('cascade');
            $table->foreign('id_pacote')->references('id_pacote')->on('pacote')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupom_pacote');
    }
};

