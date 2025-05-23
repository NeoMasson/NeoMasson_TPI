@extends('layouts.app')

<!-- Titre de la page : nom du thé -->
@section('header')
{{ $the->nom }}
@endsection

@section('content')
<!-- Container principal avec mise en page responsive -->
<div class="container mx-auto p-4">
    <!-- Grille flexible : 2 colonnes sur desktop, 1 colonne sur mobile -->
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Colonne gauche : Description et préparation -->
        <div class="flex-1">
            <div class="bg-[#FFEFCD] rounded-lg p-6 shadow-lg">
                <!-- Section description -->
                <h2 class="text-2xl font-bold mb-4">Description</h2>
                <p class="mb-6">{{ $the->description }}</p>

                <!-- Section préparation -->
                <h2 class="text-2xl font-bold mb-4">Préparation</h2>
                <p>{{ $the->preparation }}</p>
                <!-- section prix -->
                <h2 class="text-2xl font-bold mb-4"><BR>Prix</h2>
                <p>{{ $the->prix }} CHF</p>
            </div>
        </div>

        <!-- Colonne droite : Informations techniques -->
        <div class="w-full md:w-1/3">
            <div class="bg-[#FFEFCD] rounded-lg p-6 shadow-lg space-y-6">
                <!-- Quantité disponible -->
                <div>
                    <h3 class="text-xl mb-2">Quantité : {{ $the->quantite }}</h3>
                </div>
                
                <!-- Type de thé -->
                <div>
                    <h3 class="text-xl mb-2">Type : {{ $the->type->nom }}</h3>
                </div>

                <!-- Variété du thé -->
                <div>
                    <h3 class="text-xl mb-2">Variété : {{ $the->variete->nom }}</h3>
                </div>

                <!-- Provenance du thé -->
                <div>
                    <h3 class="text-xl mb-2">Provenance : {{ $the->provenance->nom }}</h3>
                </div>

                <!-- date de récolte-->
                 <div>
                 <h3 class="text-xl mb-2">
                    Date de récolte : {{ \Carbon\Carbon::parse($the->date_recolte)->format('d/m/Y') }}
                </h3>
                </div> 
            </div>
        </div>
    </div>

    <!-- Barre d'actions -->
    <div class="flex justify-between mt-8">
        <!-- Formulaire de suppression -->
        <form action="{{ route('thes.destroy', $the->id_the) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-[#967259] text-white px-8 py-3 rounded-lg hover:bg-[#7d6049] transition duration-200">
                Supprimer
            </button>
        </form>
        <!-- Bouton de modification -->
        <button onclick="window.location.href='{{ route('thes.edit', $the->id_the) }}'" class="bg-[#967259] text-white px-8 py-3 rounded-lg hover:bg-[#7d6049] transition duration-200">
            Modifier
        </button>
    </div>
</div>
@endsection