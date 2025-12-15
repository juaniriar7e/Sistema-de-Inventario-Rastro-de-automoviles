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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Cliente opcional: puede ser venta de mostrador
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Usuario del sistema que registró la venta
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->dateTime('fecha_venta')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('total', 12, 2)->default(0);

            $table->string('estado', 20)->default('COMPLETADA'); // o 'ANULADA', etc.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }

};
