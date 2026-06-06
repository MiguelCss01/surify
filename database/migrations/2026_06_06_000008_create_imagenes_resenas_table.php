<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resena_id')->constrained('resenas')->onDelete('cascade');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_resenas');
    }
};
