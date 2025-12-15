<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Parte;

class TiendaController extends Controller
{
    public function index()
    {
        $categoriasDestacadas = Categoria::withCount('partes')
            ->orderByDesc('partes_count')
            ->take(5)
            ->get();

        $ultimasPartes = Parte::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('tienda.index', compact('categoriasDestacadas', 'ultimasPartes'));
    }

    public function categorias()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('tienda.categorias', compact('categorias'));
    }

    public function categoriaPartes(Categoria $categoria)
    {
        $partes = $categoria->partes()->orderBy('nombre')->get();

        return view('tienda.categorias_partes', compact('categoria', 'partes'));
    }

    public function mostrarParte(Parte $parte)
    {
        return view('tienda.parte_show', compact('parte'));
    }
}



