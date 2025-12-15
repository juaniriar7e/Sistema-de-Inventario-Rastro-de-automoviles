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
        Schema::table('users', function (Blueprint $table) {
            // Rol del usuario (admin, operador, cliente)
            $table->string('role')->default('cliente');

            // Estado del usuario
            $table->boolean('is_active')->default(true);

            // Secreto del 2FA (luego lo usaremos)
            $table->string('secret_2fa')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active', 'secret_2fa']);
        });
    }

};
