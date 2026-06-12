<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provincia_id')->constrained('provincias')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('rango_precio'); // Bajo, Medio, Alto
            $table->string('categoria')->nullable(); // Aventura, Cultural, Gastronómico, etc
            $table->geometry('ubicacion')->nullable(); // PostGIS POINT
            $table->string('imagen_url')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinos');
    }
};
