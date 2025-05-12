<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FFEFCD] flex h-screen">
        <!-- Menu latéral - Navigation principale -->
        <aside class="w-64 bg-[#967259] h-full p-6">
            <div class="mb-10">
                <div class="w-40 h-16 mx-auto mb-6"> <img src="{{ asset('images/logo_ExceptionTea.webp') }}" alt="Logo du site"></div>
            </div>
            <nav>
                <ul class="mt-24 space-y-8">
                    @auth
                        <!-- Lien vers la page d'accueil -->
                        <li class="flex items-center space-x-2">
                            <img src="{{ asset('icons/home.png') }}" alt="Home" class="w-5 h-5">
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'font-bold' : '' }}">Accueil</a>
                        </li>
                        <!-- Lien vers la gestion des listes -->
                        <li class="flex items-center space-x-2">
                            <img src="{{ asset('icons/list.png') }}" alt="List" class="w-5 h-5">
                            <a href="{{ route('listes.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('listes.*') ? 'font-bold' : '' }}">Listes</a>
                        </li>
                        <!-- Lien pour ajouter un nouveau thé -->
                        <li class="flex items-center space-x-2">
                            <img src="{{ asset('icons/add.png') }}" alt="Add" class="w-5 h-5">
                            <a href="{{ route('thes.create') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('thes.create') ? 'font-bold' : '' }}">Ajouter un thé</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 p-8">
            @auth
                <!-- En-tête de la page -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-center bg-[#967259] text-white py-3 rounded-lg">
                        @yield('header', 'Accueil')
                    </h1>
                </div>

                <!-- Messages de notification -->
                @include('partials.flash-messages')

                <!-- Zone de contenu principale -->
                <div class="bg-[#F4E5C3] rounded-lg shadow-lg">
                    @yield('content')
                </div>
            @else
                <!-- Page de connexion/inscription -->
                <div class="flex items-center justify-center h-full">
                    <div class="bg-[#F4E5C3] rounded-lg shadow-lg p-8 max-w-md w-full text-center">
                        <h1 class="text-3xl font-bold mb-6">Bienvenue sur ExceptionTea</h1>
                        <div class="space-y-4">
                            <a href="{{ route('login') }}" class="block w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049] transition">Se connecter</a>
                            <a href="{{ route('register') }}" class="block w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049] transition">S'enregistrer</a>
                        </div>
                    </div>
                </div>
            @endif
        </main>

        <!-- Scripts supplémentaires -->
        @stack('scripts')
    </body>
</html>
