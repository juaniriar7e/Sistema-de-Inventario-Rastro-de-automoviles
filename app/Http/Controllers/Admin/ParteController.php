<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Inventario\InventarioService;
use App\Models\Auto;
use App\Models\Categoria;
use App\Models\Parte; // <-- IMPORTANTE (Eloquent)
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Exports\PartesExport;
use Maatwebsite\Excel\Facades\Excel;

class ParteController extends Controller
{
    public function __construct(
        private InventarioService $inventarioService
    ) {}

    public function index(): View
    {
        $partes = $this->inventarioService->listarPartes();

        $categorias = Categoria::all()->keyBy('id');
        $autos      = Auto::all()->keyBy('id');

        return view('admin.partes.index', [
            'partes'     => $partes,
            'categorias' => $categorias,
            'autos'      => $autos,
        ]);
    }

    public function create(): View
    {
        $categorias = Categoria::where('is_active', true)->orderBy('nombre')->get();
        $autos      = Auto::orderBy('marca')->orderBy('modelo')->get();

        return view('admin.partes.create', compact('categorias', 'autos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'categoria_id'   => ['required', 'exists:categorias,id'],
            'auto_id'        => ['nullable', 'exists:autos,id'],
            'codigo'         => ['required', 'string', 'max:50', 'unique:partes,codigo'],
            'nombre'         => ['required', 'string', 'max:150'],
            'descripcion'    => ['nullable', 'string'],
            'costo'          => ['nullable', 'numeric', 'min:0'],
            'precio'         => ['nullable', 'numeric', 'min:0'],
            'cantidad'       => ['nullable', 'integer', 'min:0'],
            'fecha_registro' => ['nullable', 'date'],
            'imagen'         => ['nullable', 'image', 'max:2048'], // <-- IMAGEN
        ]);

        if (empty($data['fecha_registro'])) {
            $data['fecha_registro'] = now()->format('Y-m-d');
        }

        // Por defecto
        $data['thumbnail_path'] = null;
        $data['imagen_path']    = null;

        // Guardar imagen si viene
        if ($request->hasFile('imagen')) {
            $data['imagen_path'] = $request->file('imagen')->store('partes', 'public');
        }

        // Crea con tu service
        $this->inventarioService->crearParteDesdeArray($data);

        return redirect()
            ->route('admin.partes.index')
            ->with('success', 'Parte creada correctamente.');
    }

    public function edit(int $id): View
    {
        // OJO: usar Eloquent aquí para que el Blade pueda leer imagen_path sin líos de propiedades privadas
        $parte = Parte::findOrFail($id);

        $categorias = Categoria::where('is_active', true)->orderBy('nombre')->get();
        $autos      = Auto::orderBy('marca')->orderBy('modelo')->get();

        return view('admin.partes.edit', compact('parte', 'categorias', 'autos'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $parteModel = Parte::findOrFail($id);

        $data = $request->validate([
            'categoria_id'   => ['required', 'exists:categorias,id'],
            'auto_id'        => ['nullable', 'exists:autos,id'],
            'codigo'         => ['required', 'string', 'max:50', "unique:partes,codigo,{$id}"],
            'nombre'         => ['required', 'string', 'max:150'],
            'descripcion'    => ['nullable', 'string'],
            'costo'          => ['nullable', 'numeric', 'min:0'],
            'precio'         => ['nullable', 'numeric', 'min:0'],
            'cantidad'       => ['nullable', 'integer', 'min:0'],
            'fecha_registro' => ['nullable', 'date'],
            'imagen'         => ['nullable', 'image', 'max:2048'], // <-- IMAGEN
        ]);

        if (empty($data['fecha_registro'])) {
            $data['fecha_registro'] = now()->format('Y-m-d');
        }

        // Si suben imagen nueva, reemplazar
        if ($request->hasFile('imagen')) {
            // borrar anterior si existía
            if (!empty($parteModel->imagen_path) && Storage::disk('public')->exists($parteModel->imagen_path)) {
                Storage::disk('public')->delete($parteModel->imagen_path);
            }

            $data['imagen_path'] = $request->file('imagen')->store('partes', 'public');
        } else {
            // si no suben nada, NO tocar imagen_path
            unset($data['imagen_path']);
        }

        // Actualiza con tu service (campos “normales”)
        $this->inventarioService->actualizarParteDesdeArray($id, $data);

        // Asegurar persistencia de imagen_path aunque el service lo ignore
        if (array_key_exists('imagen_path', $data)) {
            $parteModel->imagen_path = $data['imagen_path'];
            $parteModel->save();
        }

        return redirect()
            ->route('admin.partes.index')
            ->with('success', 'Parte actualizada correctamente.');
    }

    public function activar(int $id): RedirectResponse
    {
        $this->inventarioService->activarParte($id);

        return redirect()
            ->route('admin.partes.index')
            ->with('success', 'Parte activada correctamente.');
    }

    public function desactivar(int $id): RedirectResponse
    {
        $this->inventarioService->desactivarParte($id);

        return redirect()
            ->route('admin.partes.index')
            ->with('success', 'Parte desactivada correctamente.');
    }

    public function exportarExcel()
    {
        return Excel::download(new PartesExport, 'inventario_partes.xlsx');
    }
}
