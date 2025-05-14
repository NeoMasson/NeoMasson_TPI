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
        <aside class="w-64 bg-[#967259] h-full p-6 flex flex-col">
            <div class="mb-10">
                <div class="w-40 h-16 mx-auto mb-6"> <img src="{{ asset('images/logo_ExceptionTea.webp') }}" alt="Logo du site"></div>
            </div>
            <nav class="flex-grow">
                <ul class="mt-24 space-y-8">
                    @auth
                        <!-- Lien vers la page d'accueil -->
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('dashboard') ? 'font-bold' : '' }}">Accueil</a>
                        </li>
                        <!-- Lien vers la gestion des listes -->
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <a href="{{ route('listes.index') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('listes.*') ? 'font-bold' : '' }}">Listes</a>
                        </li>
                        <!-- Lien pour ajouter un nouveau thé -->
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <a href="{{ route('thes.create') }}" class="text-white hover:text-gray-200 {{ request()->routeIs('thes.create') ? 'font-bold' : '' }}">Ajouter un thé</a>
                        </li>
                    @endauth
                </ul>
            </nav>
            
            <!-- Bouton de déconnexion -->
            @auth
                <div class="mt-auto pt-4 border-t border-[#FFEFCD] border-opacity-20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-2 text-white hover:text-gray-200 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Se déconnecter</span>
                        </button>
                    </form>
                </div>
            @endauth
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
