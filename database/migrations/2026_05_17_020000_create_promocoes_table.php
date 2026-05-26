<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promocao', function (Blueprint $table) {
            $table->id('id_promocao');
            $table->string('nome');
            $table->text('descricao')->nullable();

            // percentual ou valor fixo
            $table->string('tipo_desconto')->default('percentual');
            $table->decimal('valor_desconto', 10, 2)->default(0);

            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_fim')->nullable();

            $table->unsignedInteger('limite_uso_total')->nullable();
            $table->unsignedInteger('limite_uso_por_usuario')->nullable();

            $table->string('status')->default('ativa'); // ativa/inativa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promocao');
    }
};

