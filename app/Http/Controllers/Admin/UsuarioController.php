<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Usuarios\UsuarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function __construct(
        private UsuarioService $usuarioService
    ) {}

    public function index(): View
    {
        $usuarios = $this->usuarioService->listarUsuarios();

        return view('admin.usuarios.index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function activar(int $id): RedirectResponse
    {
        try {
            $this->usuarioService->activarUsuario($id);
            return redirect()
                ->route('admin.usuarios.index')
                ->with('success', 'Usuario activado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', $e->getMessage());
        }
    }

    public function desactivar(int $id): RedirectResponse
    {
        try {
            $this->usuarioService->desactivarUsuario($id);
            return redirect()
                ->route('admin.usuarios.index')
                ->with('success', 'Usuario desactivado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', $e->getMessage());
        }
    }
}

