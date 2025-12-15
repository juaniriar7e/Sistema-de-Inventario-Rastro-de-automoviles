<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasTwoFactorEnabled()) {
            return $next($request);
        }

        if (!$request->session()->get('2fa_passed')) {
            return redirect()->route('twofactor.verify');
        }

        return $next($request);
    }
}

