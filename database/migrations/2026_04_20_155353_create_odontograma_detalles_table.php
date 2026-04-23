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
    Schema::create('odontograma_detalles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('odontograma_id')->constrained()->onDelete('cascade');
        $table->string('pieza'); // ej: 11,12,13...
        $table->string('estado')->default('sano');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontograma_detalles');
    }
};
