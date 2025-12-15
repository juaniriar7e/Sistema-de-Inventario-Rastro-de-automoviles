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
        Schema::table('partes', function (Blueprint $table) {
            $table->string('imagen')->nullable()->after('precio'); // o after('existencia') si quieres
        });
    }

    public function down(): void
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }

};
