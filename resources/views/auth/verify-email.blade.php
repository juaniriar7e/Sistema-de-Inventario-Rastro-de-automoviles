<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 text-justify">
        Gracias por registrarte en el <strong>Sistema de Inventario</strong>.
        Antes de continuar, por favor verifica tu dirección de correo electrónico haciendo clic en
        el enlace que te hemos enviado. Si no recibiste el correo, puedes solicitar uno nuevo.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600">
            Se ha enviado un nuevo enlace de verificación a la dirección de correo
            electrónico que proporcionaste durante el registro.
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button>
                Reenviar enlace de verificación
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="underline text-xs text-gray-600 hover:text-gray-900">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>

