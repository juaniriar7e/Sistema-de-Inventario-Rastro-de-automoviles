<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <h1 class="text-xl font-semibold text-gray-800 mb-2 text-center">
            Recuperar contraseña
        </h1>
        <p class="text-xs text-gray-500 mb-6 text-center">
            Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>

        {{-- Mensaje de éxito --}}
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Botón --}}
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="underline text-xs text-gray-600 hover:text-gray-900">
                Volver al inicio de sesión
            </a>

            <x-primary-button>
                Enviar enlace
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

