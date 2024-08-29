<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tranquil Mind') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <!-- Styles -->
        <style>
            body {
                font-family: "Lato", sans-serif;
            }

           .sidenav {
                height: 100%;
                width: 220px;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #dfc4f5; /* Change the color to purple */
                overflow-x: hidden;
                padding-top: 20px;
            }

           .sidenav ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

           .sidenav li {
                padding: 6px 6px 6px 32px;
                text-decoration: none;
                font-size: 18px;
                color: #818181;
                display: block;
            }

           .sidenav li a {
                color: #818181;
                text-decoration: none;
            }

           .sidenav li a:hover {
                color: #f1f1f1;
            }

           .main {
                margin-left: 250px; /* Same as the width of the sidenav */
            }

            @media screen and (max-height: 450px) {
               .sidenav {padding-top: 15px;}
               .sidenav li {font-size: 18px;}
            }

           .sidebar-header {
            background-color: #dfc4f5; /* Change the color to purple */
            padding: 20px;
                text-align: center;
            }

           .logo {
                width: 50px;
                height: 50px;
                margin: 0 auto;
            }

           .title {
                color: #fff;
                font-size: 24px;
                margin-top: 10px;
            }
        </style>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <x-banner />
        @livewire('navigation-menu')

        <div class="main"> <!-- Adjust ml-64 as needed -->
            <!-- Sidebar -->
            <div class="sidenav">
                <div class="sidebar-header">
                    <img src="{{ asset('assets/images/logo_tm.png') }}" alt="Logo" class="logo">
                    <h1 class="title">Tranquil Mind</h1>
                </div>
                <ul class="sidebar-nav">
                    <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.appointments.index') }}"><i class="fas fa-calendar-alt"></i> Upcoming Appointments</a></li>
                    <li><a href="{{ route('admin.patients.index') }}"><i class="fas fa-users"></i> Patients</a></li>
                    <li>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif    

            <!-- Page Content -->
            <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
            @yield('content')
        </div>
            </main>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireScripts
    @stack('scripts')
    @stack('modals')

</body>
</html>