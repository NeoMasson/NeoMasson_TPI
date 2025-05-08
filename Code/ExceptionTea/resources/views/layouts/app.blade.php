<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FFEFCD] flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#967259] h-full p-6">
            <div class="mb-10">
                <div class="w-32 h-16 bg-gray-300 mx-auto mb-4"></div>
            </div>
            <nav>
                <ul class="space-y-4">
                    @auth
                        <li class="flex items-center space-x-2">
                            <img src="{{ asset('icons/home.png') }}" alt="Home" class="w-5 h-5">
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200">Accueil</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <img src="{{ asset('icons/list.png') }}" alt="List" class="w-5 h-5">
                            <a href="#" class="text-white hover:text-gray-200">Listes</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <img src="{{ asset('icons/add.png') }}" alt="Add" class="w-5 h-5">
                            <a href="#" class="text-white hover:text-gray-200">Ajouter</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @auth
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-center bg-[#967259] text-white py-3">@yield('header', 'Accueil')</h1>
                </div>
                <div class="bg-[#F4E5C3] rounded-lg shadow-lg p-6">
                    @yield('content')
                </div>
            @else
                <div class="flex items-center justify-center h-full">
                    <div class="bg-[#F4E5C3] rounded-lg shadow-lg p-8 max-w-md w-full text-center">
                        <h1 class="text-3xl font-bold mb-6">Bienvenue sur ExceptionTea</h1>
                        <div class="space-y-4">
                            <a href="{{ route('login') }}" class="block w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049] transition">Se connecter</a>
                            <a href="{{ route('register') }}" class="block w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049] transition">S'enregistrer</a>
                        </div>
                    </div>
                </div>
            @endauth
        </main>
    </body>
</html>
