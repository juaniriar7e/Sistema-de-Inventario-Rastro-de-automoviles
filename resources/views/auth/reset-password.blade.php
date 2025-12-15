<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <h1 class="text-xl font-semibold text-gray-800 mb-2 text-center">
            Restablecer contraseña
        </h1>
        <p class="text-xs text-gray-500 mb-6 text-center">
            Define una nueva contraseña para tu cuenta.
        </p>

        {{-- token y email oculto --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

        {{-- Email (solo lectura) --}}
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-100"
                          type="email" name="email"
                          :value="old('email', $request->email)" readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Nueva contraseña --}}
        <div class="mt-4">
            <x-input-label for="password" value="Nueva contraseña" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirmación --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Botón --}}
        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                Guardar nueva contraseña
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>