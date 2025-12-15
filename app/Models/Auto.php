<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    protected $table = 'autos';

    protected $fillable = [
        'marca',
        'modelo',
        'anio',
        'version',
        'comentarios',
    ];

    public function partes()
    {
        return $this->hasMany(Parte::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim($this->marca . ' ' . $this->modelo . ' ' . ($this->anio ?? ''));
    }
}
