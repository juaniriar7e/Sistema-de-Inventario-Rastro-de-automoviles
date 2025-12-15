<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar formulario de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticar credenciales
        $request->authenticate();

        // Regenerar sesión por seguridad
        $request->session()->regenerate();

        $user = $request->user();

        // Si ES admin → su mundo es el dashboard.
        if ($user && $user->role === 'admin') {
            return redirect()->intended(route('dashboard'));
        }

        // Si NO es admin → su mundo es la tienda pública.
        // Aunque viniera de otra ruta protegida (como /carrito),
        // intended() respetará esa ruta si existe, pero nunca
        // lo vamos a mandar explícitamente al dashboard.
        return redirect()->intended(route('tienda.index'));
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Después de cerrar sesión, volvemos a la tienda pública.
        return redirect()->route('tienda.index');
    }
}

