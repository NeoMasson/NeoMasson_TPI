@extends('layouts.app')

@section('header')
Modifier la liste "{{ $liste->nom }}"
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('listes.update', $liste) }}" class="bg-[#FFEFCD] p-6 rounded-lg shadow-lg">
        @csrf
        @method('PUT')
        
        <!-- Nom de la liste -->
        <div class="mb-6">
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom de la liste</label>
            <input type="text" name="nom" id="nom" required
                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-[#967259] focus:ring focus:ring-[#967259] focus:ring-opacity-50"
                value="{{ old('nom', $liste->nom) }}"
                placeholder="Entrez le nom de votre liste">
            @error('nom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('listes.index') }}" 
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                Annuler
            </a>
            <button type="submit" 
                class="px-4 py-2 bg-[#967259] text-white rounded-md hover:bg-[#7d6049] transition-colors">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection