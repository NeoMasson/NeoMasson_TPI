@extends('layouts.app')

@section('header')
{{ $the->nom }}
@endsection

@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Colonne gauche -->
        <div class="flex-1">
            <div class="bg-[#FFEFCD] rounded-lg p-6 shadow-lg">
                <h2 class="text-2xl font-bold mb-4">Description</h2>
                <p class="mb-6">{{ $the->description }}</p>

                <h2 class="text-2xl font-bold mb-4">Préparation</h2>
                <p>{{ $the->preparation }}</p>
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="w-full md:w-1/3">
            <div class="bg-[#FFEFCD] rounded-lg p-6 shadow-lg space-y-6">
                <div>
                    <h3 class="text-xl mb-2">Quantité : {{ $the->quantite }}</h3>
                </div>
                
                <div>
                    <h3 class="text-xl mb-2">Type : {{ $the->type->nom }}</h3>
                </div>

                <div>
                    <h3 class="text-xl mb-2">Variété : {{ $the->variete->nom }}</h3>
                </div>

                <div>
                    <h3 class="text-xl mb-2">Provenance : {{ $the->provenance->nom }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons en bas -->
    <div class="flex justify-between mt-8">
        <form action="{{ route('thes.destroy', $the->id_the) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-[#967259] text-white px-8 py-3 rounded-lg hover:bg-[#7d6049] transition duration-200">
                Supprimer
            </button>
        </form>
        <button onclick="window.location.href='{{ route('thes.edit', $the->id_the) }}'" class="bg-[#967259] text-white px-8 py-3 rounded-lg hover:bg-[#7d6049] transition duration-200">
            Modifier
        </button>
    </div>
</div>

@endsection