<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacote_imagem', function (Blueprint $table) {
            $table->id('id_pacote_imagem');
            $table->unsignedBigInteger('id_pacote');
            $table->string('url_imagem');
            $table->unsignedInteger('ordem')->default(1);
            $table->timestamps();

            $table->foreign('id_pacote')
                ->references('id_pacote')
                ->on('pacote')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacote_imagem');
    }
};

