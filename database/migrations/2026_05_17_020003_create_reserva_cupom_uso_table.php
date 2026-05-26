<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Registra uso de cupom (para limitar por usuário/total)
        Schema::create('reserva_cupom_uso', function (Blueprint $table) {
            $table->id('id_reserva_cupom_uso');
            $table->unsignedBigInteger('id_cupom');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_reserva');
            $table->timestamps();

            $table->unique(['id_cupom', 'id_reserva']);

            $table->foreign('id_cupom')->references('id_cupom')->on('cupom')->onDelete('cascade');
            $table->foreign('id_users')->references('id_users')->on('users')->onDelete('cascade');
            $table->foreign('id_reserva')->references('id_reserva')->on('reserva')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_cupom_uso');
    }
};

