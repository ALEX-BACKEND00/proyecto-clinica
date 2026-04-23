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
    Schema::create('historia_clinicas', function (Blueprint $table) {

        $table->id();

        $table->foreignId('paciente_id')
              ->constrained()
              ->onDelete('cascade');

        $table->date('fecha');

        $table->string('odontologo')->nullable();

        $table->text('motivo_consulta')->nullable();

        $table->text('diagnostico')->nullable();

        $table->text('tratamiento')->nullable();

        $table->text('observaciones')->nullable();

        $table->date('proximo_control')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_clinicas');
    }
};
