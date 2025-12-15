<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Inventario\CategoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function __construct(
        private CategoriaService $categoriaService
    ) {}

    public function index(): View
    {
        $categorias = $this->categoriaService->listarCategorias();

        return view('admin.categorias.index', [
            'categorias' => $categorias,
        ]);
    }

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $this->categoriaService->crearCategoria(
            $data['nombre'],
            $data['descripcion'] ?? null
        );

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(int $id): View
    {
        $categoria = $this->categoriaService->obtenerCategoria($id);

        return view('admin.categorias.edit', [
            'categoria' => $categoria,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $this->categoriaService->actualizarCategoria(
            $id,
            $data['nombre'],
            $data['descripcion'] ?? null
        );

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function activar(int $id): RedirectResponse
    {
        $this->categoriaService->activarCategoria($id);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría activada correctamente.');
    }

    public function desactivar(int $id): RedirectResponse
    {
        $this->categoriaService->desactivarCategoria($id);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría desactivada correctamente.');
    }
}
