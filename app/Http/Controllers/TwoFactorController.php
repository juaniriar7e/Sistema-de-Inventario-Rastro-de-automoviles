<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    /**
     * Muestra la pantalla de configuración inicial de 2FA (generar secreto + QR).
     */
    public function showSetupForm(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Si ya tiene 2FA activo, lo mandamos a la pantalla de verificación o dashboard
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('dashboard');
        }

        $google2fa = new Google2FA();

        // Si aún no tiene secreto, generamos uno y lo guardamos temporalmente en sesión
        $secret = $request->session()->get('2fa_secret');

        if (!$secret) {
            $secret = $google2fa->generateSecretKey();
            $request->session()->put('2fa_secret', $secret);
        }

        // Generar el "otpauth" URL para apps tipo Google Authenticator
        $companyName = 'Inventario Rastro';
        $companyEmail = $user->email;

        $qrData = $google2fa->getQRCodeUrl(
            $companyName,
            $companyEmail,
            $secret
        );

        return view('twofactor.setup', [
            'qrData'    => $qrData,
            'secretKey' => $secret,
        ]);
    }

    /**
     * Procesa el código ingresado para activar la 2FA.
     */
    public function enable(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $secret = $request->session()->get('2fa_secret');

        if (!$secret) {
            return redirect()
                ->route('twofactor.setup')
                ->with('error', 'No se encontró el secreto de 2FA en sesión. Intente de nuevo.');
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($secret, $request->input('code'));

        if (!$valid) {
            return redirect()
                ->route('twofactor.setup')
                ->with('error', 'El código 2FA no es válido. Intente de nuevo.');
        }

        // Guardamos el secreto encriptado en BD y activamos el flag
        $user->two_factor_secret = Crypt::encryptString($secret);
        $user->two_factor_enabled = true;
        $user->save();

        // Limpiamos sesión y marcamos que ya pasó 2FA en esta sesión
        $request->session()->forget('2fa_secret');
        $request->session()->put('2fa_passed', true);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Autenticación de dos factores activada correctamente.');
    }

    /**
     * Muestra la pantalla para ingresar código 2FA al iniciar sesión.
     */
    public function showVerifyForm(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Si el usuario no tiene 2FA activo, lo mandamos al dashboard
        if (!$user->hasTwoFactorEnabled()) {
            return redirect()->route('dashboard');
        }

        // Si ya pasó 2FA en esta sesión, no tiene que volver a hacerlo
        if ($request->session()->get('2fa_passed')) {
            return redirect()->route('dashboard');
        }

        return view('twofactor.verify');
    }

    /**
     * Verifica el código 2FA después del login.
     */
    public function verify(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        if (!$user->hasTwoFactorEnabled()) {
            return redirect()->route('dashboard');
        }

        if (!$user->two_factor_secret) {
            return redirect()->route('dashboard');
        }

        $secret = Crypt::decryptString($user->two_factor_secret);

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->input('code'));

        if (!$valid) {
            return redirect()
                ->route('twofactor.verify')
                ->with('error', 'Código 2FA incorrecto. Intente nuevamente.');
        }

        // Marcamos que esta sesión ya pasó 2FA
        $request->session()->put('2fa_passed', true);

        // Puedes redirigir a dashboard o a donde gustes
        return redirect()->route('dashboard');
    }

    /**
     * (Opcional) Desactivar 2FA para el usuario actual.
     */
    public function disable(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $user->two_factor_secret = null;
        $user->two_factor_enabled = false;
        $user->save();

        $request->session()->forget('2fa_passed');

        return redirect()
            ->route('dashboard')
            ->with('success', 'Autenticación de dos factores desactivada.');
    }
}
