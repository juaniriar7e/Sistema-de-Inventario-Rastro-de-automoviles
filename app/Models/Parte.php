<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parte extends Model
{
    use HasFactory;

    protected $table = 'partes';

    protected $fillable = [
        'categoria_id',
        'auto_id',
        'codigo',
        'nombre',
        'descripcion',
        'costo',
        'precio',
        'cantidad',
        'thumbnail_path',
        'imagen_path',
        'fecha_registro',
        'is_active',
        'imagen',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'is_active'      => 'boolean',
        'costo'          => 'decimal:2',
        'precio'         => 'decimal:2',
        'cantidad'       => 'integer',
    ];

    /**
     * ✅ COMPATIBILIDAD:
     * Si en la tienda/vistas usas $parte->existencia,
     * esto lo mapea automáticamente a la columna real: cantidad.
     */
    public function getExistenciaAttribute()
    {
        return (int) ($this->cantidad ?? 0);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function auto()
    {
        return $this->belongsTo(Auto::class);
    }
}
