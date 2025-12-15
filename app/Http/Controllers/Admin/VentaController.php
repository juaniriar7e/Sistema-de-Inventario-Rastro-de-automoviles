<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Ventas\VentaService;
use App\Models\Parte;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class VentaController extends Controller
{
    public function index(): View
    {
        $ventas = Venta::with(['cliente', 'usuario'])
            ->orderByDesc('fecha_venta')
            ->get();

        return view('admin.ventas.index', [
            'ventas' => $ventas,
        ]);
    }

    public function create(): View
    {
        $partes = Parte::where('is_active', true)
            ->orderBy('nombre')
            ->get();

        $clientes = \App\Models\Cliente::orderBy('nombre')->get();

        return view('admin.ventas.create', [
            'partes'   => $partes,
            'clientes' => $clientes,
        ]);
    }

    public function store(Request $request, VentaService $ventaService): RedirectResponse
    {
        $data = $request->validate([
            'cliente_id' => ['nullable', 'integer'],
            'partes' => ['required', 'array'],
            'partes.*.parte_id' => ['nullable', 'integer'],
            'partes.*.cantidad' => ['nullable', 'integer', 'min:1'],
            'partes.*.precio_unitario' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            $venta = $ventaService->crearVenta(
                $data['cliente_id'] ?? null,
                $data['partes'] ?? []
            );
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.ventas.show', $venta->getId())
            ->with('success', 'Venta registrada correctamente.');
    }

    public function show(int $id): View
    {
        $venta = Venta::with(['detalles.parte', 'usuario', 'cliente'])->findOrFail($id);
        return view('admin.ventas.show', compact('venta'));
    }
}
