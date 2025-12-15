<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Inventario\AutoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AutoController extends Controller
{
    public function __construct(
        private AutoService $autoService
    ) {}

    public function index(): View
    {
        $autos = $this->autoService->listarAutos();

        return view('admin.autos.index', [
            'autos' => $autos,
        ]);
    }

    public function create(): View
    {
        return view('admin.autos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'marca'       => ['required', 'string', 'max:100'],
            'modelo'      => ['required', 'string', 'max:100'],
            'anio'        => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'version'     => ['nullable', 'string', 'max:100'],
            'comentarios' => ['nullable', 'string'],
        ]);

        $this->autoService->crearAutoDesdeArray($data);

        return redirect()
            ->route('admin.autos.index')
            ->with('success', 'Auto creado correctamente.');
    }

    public function edit(int $id): View
    {
        $auto = $this->autoService->obtenerAuto($id);

        return view('admin.autos.edit', [
            'auto' => $auto,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'marca'       => ['required', 'string', 'max:100'],
            'modelo'      => ['required', 'string', 'max:100'],
            'anio'        => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'version'     => ['nullable', 'string', 'max:100'],
            'comentarios' => ['nullable', 'string'],
        ]);

        $this->autoService->actualizarAutoDesdeArray($id, $data);

        return redirect()
            ->route('admin.autos.index')
            ->with('success', 'Auto actualizado correctamente.');
    }
}

