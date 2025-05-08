@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-[#FFEFCD] flex flex-col items-center pt-6 sm:pt-0">
        <a href="/">
            <h1 class="text-3xl font-bold mb-6 text-[#967259]">ExceptionTea</h1>
        </a>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[#F4E5C3] shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-center">Content de vous revoir!</h2>
                <p class="text-center mt-2">Entrez vos identifiants pour accéder à votre compte</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#967259] focus:border-[#967259]">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#967259] focus:border-[#967259]">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#967259] shadow-sm focus:ring-[#967259]">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-[#967259] hover:bg-[#7d6049] text-white font-semibold rounded-md transition duration-200">
                    S'authentifier
                </button>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Vous n'avez pas de compte? 
                        <a href="{{ route('register') }}" class="text-[#967259] hover:underline">Inscrivez-vous</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
