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
    Schema::create('resenas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('destino_id')->nullable()->constrained('destinos')->onDelete('cascade');
        $table->foreignId('evento_id')->nullable()->constrained('eventos')->onDelete('cascade');
        $table->integer('calificacion'); // Del 1 al 5
        $table->text('comentario');
        $table->json('imagenes')->nullable(); // Para guardar múltiples fotos
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
