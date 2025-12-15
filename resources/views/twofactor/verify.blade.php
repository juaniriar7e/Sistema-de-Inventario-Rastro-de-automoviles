{{-- resources/views/twofactor/verify.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verificar Código 2FA') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4 text-sm">
                        Ingresa el código de 6 dígitos generado por tu aplicación de autenticación (Google Authenticator, etc.).
                    </p>

                    <form method="POST" action="{{ route('twofactor.verify.post') }}" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Código 2FA
                            </label>
                            <input type="text" name="code" maxlength="6"
                                   class="w-full border rounded px-2 py-1 text-sm"
                                   autofocus>
                        </div>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                            Verificar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
