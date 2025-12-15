<?php

namespace App\Http\Controllers;

use App\Models\Parte;
use App\Models\Categoria;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventarioPublicoController extends Controller
{
    /**
     * Inventario de partes en solo lectura, con filtro por categoría.
     */
    public function indexPartes(Request $request): View
    {
        // id de categoría seleccionada (puede venir null)
        $categoriaId = $request->query('categoria_id');

        $categorias = Categoria::orderBy('nombre')->get();

        $partesQuery = Parte::with(['categoria', 'auto'])
            ->orderBy('nombre');

        if ($categoriaId) {
            $partesQuery->where('categoria_id', $categoriaId);
        }

        $partes = $partesQuery->get();

        return view('inventario.partes.index', [
            'partes'       => $partes,
            'categorias'   => $categorias,
            'categoriaId'  => $categoriaId,
        ]);
    }

    /**
     * Catálogo de autos en solo lectura para usuarios autenticados.
     */
    public function indexAutos(): View
    {
        $autos = Auto::orderBy('marca')
            ->orderBy('modelo')
            ->orderBy('anio', 'desc')
            ->get();

        return view('inventario.autos.index', [
            'autos' => $autos,
        ]);
    }
}

