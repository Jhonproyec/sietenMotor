@php
$menu = [
[
'name' => 'Clientes',
'icon' => 'users',
'url' => route('admin.clientes.index'),
'current' => request()->routeIs('admin.clientes.*')
],
[
'name' => 'Vehículos',
'icon' => 'truck',
'url' => route('admin.vehiculos.index'),
'current' => request()->routeIs('admin.vehiculos.*')
],
];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        /* Sidebar */
        #sidebar-wrapper {
            position: fixed;
            top: 0;
            left: -320px;
            width: 300px;
            height: 100%;
            background: rgb(245, 245, 245);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            padding-top: 20px;
            overflow: hidden;
        }

        #sidebar-wrapper.active {
            left: 0;
        }

        .card-content {
            width: 100%;
        }

        /* Contenido */
        #page-content-wrapper {
            margin-top: 30px;
        }

        .content {
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
            height: 100%;
            padding: 10px;
        }

        .menu {
            margin-top: 35px;
            margin-left: -15px;
            width: 100%;
            font-size: 17px;
        }
        .menu a{
            color: rgb(82, 82, 82);
        }

        .menu-item {
            padding: 12px 10px;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        .active {
            width: 100%;
            display: block;
            background-color: rgba(23, 188, 155, 0.2);
            border-radius: 5px

        }

        .menu .active  {
            color: #17bc9a;
        }

        #page-content-wrapper.sidebar-active {
            margin-left: 250px;
        }

        #sidebar-wrapper img {
            width: 220px;
        }

        /* Navbar */
        .navbar-header {
            width: 100%;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 999;

        }

        /* Botón del menú */
        .hamburger {
            width: 38px;
            height: 38px;
            font-size: 20px;
            color: #17bc9a;
            background-color: rgba(23, 188, 155, 0.2);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .hamburger.sidebar-active {
            transform: translateX(310px);
        }

        .logo {
            width: 100px;
            height: 90px;
            box-sizing: border-box;
            margin-left: 10px;
        }
    </style>
</head>



<body>
    <div id="sidebar-wrapper" class="active d-flex flex-column">
        <h3 class="text-center">
            <img class="logo" src="{{ asset('img/sietemotor-logo.png') }}" alt="Logo taller Sieten Motor">

        </h3>
        <ul class="menu ">
            <div class="top">
                <a class="{{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}" href="{{route('admin.clientes.index')}}">
                    <li class="menu-item">
                        <i class="fa-solid fa-users"></i> Clientes
                    </li>
                </a>
                <a class="{{ request()->routeIs('admin.vehiculos.*') ? 'active' : '' }}" href="{{route('admin.vehiculos.index')}}">
                    <li class="menu-item">
                        <i class="fa-solid fa-car-rear"></i> Vehículos
                    </li>
                </a>
            </div>
        
        </ul>
        <!-- Se usa mt-auto para empujar la sección al fondo -->
        <div class="button mt-auto mb-4">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </div>
        
    </div>

    <div class="navbar-header">
        <button type="button" class="hamburger sidebar-active" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="card-content">
        <div id="page-content-wrapper" class="sidebar-active">
            <div class="content">
                {{ $slot }}

                @fluxScripts
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('page-content-wrapper');

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                content.classList.toggle('sidebar-active');
                menuToggle.classList.toggle('sidebar-active');
            });
        });
    </script>
</body>

</html>