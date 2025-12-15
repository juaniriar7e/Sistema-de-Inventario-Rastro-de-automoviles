<?php

namespace App\Exports;

use App\Models\Parte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PartesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Parte::select(
            'codigo',
            'nombre',
            'descripcion',
            'precio',
            'cantidad',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Código',
            'Nombre',
            'Descripción',
            'Precio',
            'Cantidad en stock',
            'Fecha de registro',
        ];
    }
}
