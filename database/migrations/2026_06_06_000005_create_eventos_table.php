<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provincia_id')->constrained('provincias')->onDelete('cascade');
            $table->foreignId('destino_id')->nullable()->constrained('destinos')->onDelete('cascade');
            $table->string('nombre');
            $table->string('tipo'); // Musical, Gastronómico, Deportivo, Cultural
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->geometry('ubicacion')->nullable(); // PostGIS POINT
            $table->string('rango_precio')->nullable(); // Bajo, Medio, Alto
            $table->string('imagen_url')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
