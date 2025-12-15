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
        Schema::create('partes', function (Blueprint $table) {
            $table->id();

            // Relación con categoría (obligatoria)
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Relación con auto (opcional, una parte puede no estar ligada a un auto específico)
            $table->foreignId('auto_id')
                ->nullable()
                ->constrained('autos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('codigo', 50)->unique();         // código interno de la parte
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();

            $table->decimal('costo', 10, 2)->default(0);    // costo para el negocio
            $table->decimal('precio', 10, 2)->default(0);   // precio de venta
            $table->integer('cantidad')->default(0);        // stock

            $table->string('thumbnail_path')->nullable();   // ruta imagen miniatura
            $table->string('imagen_path')->nullable();      // ruta imagen principal

            $table->date('fecha_registro')->nullable();
            $table->boolean('is_active')->default(true);    // para desactivar sin borrar

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partes');
    }

};
