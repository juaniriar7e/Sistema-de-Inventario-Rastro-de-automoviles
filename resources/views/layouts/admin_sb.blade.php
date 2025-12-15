{{-- resources/views/layouts/admin_sb.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | Inventario Rastro')</title>

    {{-- SB Admin 2 usa Bootstrap 4 + FontAwesome (CDN, opción 1) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    {{-- Estilo aproximado SB Admin 2 (sin bajar archivos) --}}
    <style>
        body { background: #f8f9fc; }
        .sidebar { min-height: 100vh; }
        .sidebar .nav-link { color: rgba(255,255,255,.85); }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.08); border-radius: .35rem; }
        .sidebar .sidebar-brand { color:#fff; font-weight:700; letter-spacing:.5px; }
        .content-wrapper { width: 100%; }
        .topbar { background: #fff; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); }
        .card { border: 0; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); border-radius: .35rem; }
        .btn-icon-split .icon { background: rgba(0,0,0,.15); display:inline-block; padding:.375rem .75rem; }
        .btn-icon-split .text { display:inline-block; padding:.375rem .75rem; }
        .text-gray-700 { color:#5a5c69 !important; }
    </style>
</head>

<body>
<div id="wrapper" class="d-flex">

    {{-- SIDEBAR --}}
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion">

        <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="sidebar-brand-text mx-2">Inventario Rastro</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading text-uppercase small">
            Administración
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.usuarios.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Usuarios</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categorias.index') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Categorías</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.autos.index') }}">
                <i class="fas fa-fw fa-car"></i>
                <span>Autos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.partes.index') }}">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Partes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.clientes.index') }}">
                <i class="fas fa-fw fa-id-card"></i>
                <span>Clientes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ventas.index') }}">
                <i class="fas fa-fw fa-receipt"></i>
                <span>Ventas</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading text-uppercase small">
            Mi cuenta
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Perfil</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('twofactor.setup') }}">
                <i class="fas fa-fw fa-shield-alt"></i>
                <span>Configurar 2FA</span>
            </a>
        </li>

        {{-- BOTÓN REGRESAR A LA TIENDA (lo que pediste) --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tienda.index') }}">
                <i class="fas fa-fw fa-store"></i>
                <span>Regresar a la tienda</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    </ul>

    {{-- CONTENT --}}
    <div class="content-wrapper">

        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top">
            <span class="navbar-brand mb-0 h6 text-gray-700">@yield('page_title', 'Panel principal')</span>

            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item mr-3 text-gray-700 small">
                    {{ auth()->user()->name ?? 'admin' }}
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-dark btn-sm" type="submit">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <div class="container-fluid pb-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

{{-- JS (Bootstrap 4) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
