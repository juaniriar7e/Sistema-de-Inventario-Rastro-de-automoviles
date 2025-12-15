<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <h1 class="text-xl font-semibold text-gray-800 mb-2 text-center">
            Confirmar contraseña
        </h1>
        <p class="text-xs text-gray-500 mb-6 text-center">
            Por motivos de seguridad, confirma tu contraseña antes de continuar.
        </p>

        {{-- Password --}}
        <div>
            <x-input-label for="password" value="Contraseña actual" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Botón --}}
        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                Confirmar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

