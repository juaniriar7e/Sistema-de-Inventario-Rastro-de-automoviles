<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();

        return view('admin.clientes.index', [
            'clientes' => $clientes,
        ]);
    }

    public function create(): View
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:150'],
            'email'     => ['nullable', 'email', 'max:150'],
            'telefono'  => ['nullable', 'string', 'max:50'],
            'cedula'    => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string'],
        ]);

        Cliente::create($data);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function edit(int $id): View
    {
        $cliente = Cliente::findOrFail($id);

        return view('admin.clientes.edit', [
            'cliente' => $cliente,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:150'],
            'email'     => ['nullable', 'email', 'max:150'],
            'telefono'  => ['nullable', 'string', 'max:50'],
            'cedula'    => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string'],
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($data);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }
}
