@extends('layouts.app')

@section('header')
<div class="flex items-center">
    <a href="{{ route('thes.show', $the) }}" class="mr-4">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
    </a>
    <span>Modifier {{ $the->nom }}</span>
</div>
@endsection

@section('content')
<form action="{{ route('thes.update', $the) }}" method="POST" class="grid grid-cols-2 gap-6">
    @csrf
    @method('PUT')
    
    <!-- Colonne de gauche -->
    <div class="space-y-6">
        <div class="bg-[#FFEFCD] p-6 rounded-lg">
            <h2 class="text-xl font-bold text-[#4A3428] mb-4">Description</h2>
            <div class="bg-[#F4E5C3] p-4 rounded">
                <textarea name="description" rows="6" 
                    class="w-full bg-white rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">{{ $the->description }}</textarea>
            </div>
        </div>

        <div class="bg-[#FFEFCD] p-6 rounded-lg">
            <h2 class="text-xl font-bold text-[#4A3428] mb-4">Préparation</h2>
            <div class="bg-[#F4E5C3] p-4 rounded">
                <textarea name="preparation" rows="6"
                    class="w-full bg-white rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">{{ $the->preparation }}</textarea>
            </div>
        </div>
    </div>

    <!-- Colonne de droite -->
    <div class="bg-[#FFEFCD] p-6 rounded-lg">
        <div class="space-y-6">
            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Quantité (g)</label>
                <input type="number" name="quantite" value="{{ $the->quantite }}"
                    class="w-full bg-white rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
            </div>

            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Type</label>
                <select name="type_id" 
                    class="w-full bg-white rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    @foreach($types as $type)
                        <option value="{{ $type->id_type }}" 
                            {{ $the->fk_id_type == $type->id_type ? 'selected' : '' }}>
                            {{ $type->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Variété</label>
                <select name="variete_id"
                    class="w-full bg-white rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    @foreach($varietes as $variete)
                        <option value="{{ $variete->id_variete }}"
                            {{ $the->fk_id_variete == $variete->id_variete ? 'selected' : '' }}>
                            {{ $variete->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Provenance</label>
                <select name="provenance_id"
                    class="w-full bg-white rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    @foreach($provenances as $provenance)
                        <option value="{{ $provenance->id_provenance }}"
                            {{ $the->fk_id_provenance == $provenance->id_provenance ? 'selected' : '' }}>
                            {{ $provenance->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Boutons en bas -->
    <div class="col-span-2 flex justify-between bg-[#967259] rounded-lg overflow-hidden">
        <a href="{{ route('thes.show', $the) }}" 
            class="flex-1 py-4 text-center text-white hover:bg-[#7d6049] transition-colors border-r border-[#7d6049]">
            Annuler
        </a>
        <button type="submit" class="flex-1 py-4 text-white hover:bg-[#7d6049] transition-colors">
            Enregistrer
        </button>
    </div>
</form>
@endsection