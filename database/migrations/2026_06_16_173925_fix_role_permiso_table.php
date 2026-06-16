<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('role_permiso', function (Blueprint $table) {
            $table->dropPrimary();
            if (Schema::hasColumn('role_permiso', 'id')) {
                $table->dropColumn('id');
            }
            $table->primary(['role_id', 'permiso_id']);
        });
    }

    public function down(): void
    {
        Schema::table('role_permiso', function (Blueprint $table) {
            $table->dropPrimary(['role_id', 'permiso_id']);
            $table->id();
        });
    }
};