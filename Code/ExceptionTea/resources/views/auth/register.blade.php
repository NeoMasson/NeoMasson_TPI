@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-[#FFEFCD] flex flex-col items-center pt-6 sm:pt-0">
        <div class="w-full bg-[#967259] py-6 mb-6">
            <h1 class="text-3xl font-bold text-white text-center">S'enregistrer</h1>
        </div>

        <div class="w-full sm:max-w-md px-6 py-4 bg-[#F4E5C3] shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-8">
            <h2 class="text-2xl font-bold text-center">Commencez dès maintenant</h2>
                <p class="text-center mt-2">Créez de nouveaux identifiants pour votre compte</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#967259] focus:border-[#967259]">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#967259] focus:border-[#967259]">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#967259] focus:border-[#967259]">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe-->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Confirmation du mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#967259] focus:border-[#967259]">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-[#967259] hover:bg-[#7d6049] text-white font-semibold rounded-md transition duration-200">
                    S'enregistrer
                </button>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Vous avez déjà un compte?
                        <a href="{{ route('login') }}" class="text-[#967259] hover:underline">S'authentifier</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
