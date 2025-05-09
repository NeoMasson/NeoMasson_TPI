@extends('layouts.app')

@section('header')
Modifier la liste "{{ $liste->nom }}"
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('listes.update', $liste) }}" class="bg-[#FFEFCD] p-6 rounded-lg shadow-lg">
        @csrf
        @method('PUT')
        
        <!-- Nom de la liste -->
        <div class="mb-6">
            <label for="nom" class="block text-lg font-bold text-[#4A3428] mb-2">Nom de la liste</label>
            <input type="text" name="nom" id="nom" required
                class="w-full px-4 py-2 rounded-md bg-input focus:border-[#967259] focus:ring focus:ring-[#967259] focus:ring-opacity-50"
                value="{{ old('nom', $liste->nom) }}"
                placeholder="Entrez le nom de votre liste">
            @error('nom')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Section de sélection des thés -->
        <div class="mb-6">
            <label class="block text-lg font-bold text-[#4A3428] mb-2">Sélectionnez les thés à inclure</label>
            <div class="bg-[#F4E5C3] rounded-lg p-4 max-h-96 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($thes as $the)
                    <div class="flex items-start space-x-3 p-3 border rounded-lg bg-input hover:bg-[#E8DAB8]">
                        <input type="checkbox" name="thes[]" value="{{ $the->id_the }}" id="the_{{ $the->id_the }}"
                            {{ $liste->thes->contains($the->id_the) ? 'checked' : '' }}
                            class="mt-1 rounded text-[#967259] focus:ring-[#967259]">
                        <label for="the_{{ $the->id_the }}" class="cursor-pointer">
                            <div class="font-medium text-[#4A3428]">{{ $the->nom }}</div>
                            <div class="text-sm text-gray-600">
                                Type: {{ $the->type->nom }} | 
                                Variété: {{ $the->variete->nom }} | 
                                Provenance: {{ $the->provenance->nom }}
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @error('thes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons d'action -->
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