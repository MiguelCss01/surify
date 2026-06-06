<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destino_id')->nullable()->constrained('destinos')->onDelete('cascade');
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->onDelete('cascade');
            $table->integer('calificacion');
            $table->string('titulo')->nullable();
            $table->text('comentario');
            $table->boolean('anonima')->default(false);
            $table->boolean('aprobada')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
