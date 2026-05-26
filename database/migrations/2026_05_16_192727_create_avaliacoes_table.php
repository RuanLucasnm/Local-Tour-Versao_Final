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
        Schema::create('avaliacao', function (Blueprint $table) {
            $table->id('id_avaliacao');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_pacote');
            $table->integer('nota');
            $table->text('comentario')->nullable();
            $table->string('status_moderacao');
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users');
            $table->foreign('id_pacote')->references('id_pacote')->on('pacote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
