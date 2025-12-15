{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Título --}}
        <h1 class="text-xl font-semibold text-gray-800 mb-2 text-center">
            Iniciar sesión
        </h1>
        <p class="text-xs text-gray-500 mb-6 text-center">
            Accede al panel de administración del Sistema de Inventario.
        </p>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember --}}
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-800"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">
                    Recordarme en este equipo
                </span>
            </label>
        </div>

        {{-- Links + botón --}}
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-xs text-gray-600 hover:text-gray-900"
                   href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Ingresar') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center text-xs text-gray-500">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="underline hover:text-gray-700">
                Regístrate aquí
            </a>
        </div>
    </form>
</x-guest-layout>
