<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard SB Admin 2 | {{ config('app.name') }}</title>

    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">

<div id="wrapper">

    {{-- Sidebar SB Admin 2 --}}
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Inventario</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.sb2') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>SB Admin 2</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Administración</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.partes.index') }}">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Partes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ventas.index') }}">
                <i class="fas fa-fw fa-receipt"></i>
                <span>Ventas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.reportes.inventario_csv') }}">
                <i class="fas fa-fw fa-file-excel"></i>
                <span>Exportar Inventario (CSV)</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    {{-- Content Wrapper --}}
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            {{-- Topbar --}}
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <span class="ml-2 text-gray-700">Panel SB Admin 2</span>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i> Volver al Panel Admin
                            </a>
                            <div class="dropdown-divider"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            {{-- Main Content --}}
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Dashboard (Plantilla)</h1>

                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Inventario</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Acceso rápido a módulos
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Reportes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Exportación CSV para Excel
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tienda</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Pública + carrito
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>© {{ date('Y') }} {{ config('app.name') }}</span>
                </div>
            </div>
        </footer>

    </div>
</div>

<script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
