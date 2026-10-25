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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');          // Ej: Autel MaxiCOM MK808
        $table->string('marca');           // Ej: Autel, Launch
        $table->text('descripcion');       // Características técnicas
        $table->decimal('precio', 10, 2);  // Precio con decimales
        $table->string('imagen');          // Ruta de la foto
        $table->integer('stock');          // Cantidad disponible
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
