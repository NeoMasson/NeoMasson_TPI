@extends('layouts.app')

{{-- En-tête de la page avec bouton de retour --}}
@section('header')
<div class="flex items-center">
    {{-- Bouton de retour avec icône flèche --}}
    <a href="{{ route('thes.show', $the) }}" class="mr-4">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
    </a>
    <span>Modifier le {{ $the->nom }}</span>
</div>
@endsection

@section('content')
<!-- Affichage des erreurs de validation en français avec style amélioré -->
@if ($errors->any())
    <div class="max-w-4xl mx-auto mt-4 mb-6 bg-[#F4E5C3] border-l-4 border-[#967259] p-4 rounded-md shadow-md">
        <div class="flex items-center mb-2">
            <svg class="w-6 h-6 text-[#967259] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-[#4A3428]">Attention ! Veuillez corriger les erreurs suivantes :</h3>
        </div>
        <ul class="list-disc list-inside text-[#4A3428] pl-2">
            @foreach ($errors->all() as $error)
                <li class="py-1">
                    @switch(true)
                        @case(strpos($error, 'The description field is required') !== false)
                            Une description est requise
                            @break
                        @case(strpos($error, 'The preparation field is required') !== false)
                            Les instructions de préparation sont nécessaires
                            @break
                        @case(strpos($error, 'The quantite field is required') !== false)
                            La quantité est obligatoire
                            @break
                        @case(strpos($error, 'The type id field is required') !== false)
                            Veuillez sélectionner un type de thé
                            @break
                        @case(strpos($error, 'The variete id field is required') !== false)
                            Veuillez sélectionner une variété de thé
                            @break
                        @case(strpos($error, 'The provenance id field is required') !== false)
                            Veuillez sélectionner une provenance
                            @break
                        @case(strpos($error, 'must be a number') !== false)
                            La valeur doit être un nombre
                            @break
                        @case(strpos($error, 'must be at least') !== false)
                            La valeur doit être un nombre positif
                            @break
                        @default
                            {{ $error }}
                    @endswitch
                </li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Formulaire d'édition avec mise en page en grille --}}
<form action="{{ route('thes.update', $the) }}" method="POST" class="grid grid-cols-2 gap-6">
    {{-- Protection CSRF et méthode PUT pour l'édition --}}
    @csrf
    @method('PUT')
    
    {{-- Colonne gauche : Description et Préparation --}}
    <div class="space-y-6">
        {{-- Section Description --}}
        <div class="bg-[#FFEFCD] p-6 rounded-lg">
            <h2 class="text-xl font-bold text-[#4A3428] mb-4">Description</h2>
            <div class="bg-[#F4E5C3] p-4 rounded">
                <textarea name="description" rows="6" 
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">{{ $the->description }}</textarea>
            </div>
        </div>

        {{-- Section Préparation --}}
        <div class="bg-[#FFEFCD] p-6 rounded-lg">
            <h2 class="text-xl font-bold text-[#4A3428] mb-4">Préparation</h2>
            <div class="bg-[#F4E5C3] p-4 rounded">
                <textarea name="preparation" rows="6"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">{{ $the->preparation }}</textarea>
            </div>
        </div>
    </div>

    {{-- Colonne droite : Caractéristiques du thé --}}
    <div class="bg-[#FFEFCD] p-6 rounded-lg">
        <div class="space-y-6">
            {{-- Champ Quantité --}}
            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Quantité</label>
                <input type="number" name="quantite" value="{{ $the->quantite }}"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
            </div>

            {{-- Liste déroulante Type --}}
            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Type</label>
                <select name="type_id" 
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    @foreach($types as $type)
                        <option value="{{ $type->id_type }}" 
                            {{ $the->fk_id_type == $type->id_type ? 'selected' : '' }}>
                            {{ $type->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Liste déroulante Variété --}}
            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Variété</label>
                <select name="variete_id"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    @foreach($varietes as $variete)
                        <option value="{{ $variete->id_variete }}"
                            {{ $the->fk_id_variete == $variete->id_variete ? 'selected' : '' }}>
                            {{ $variete->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Liste déroulante Provenance --}}
            <div>
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Provenance</label>
                <select name="provenance_id"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    @foreach($provenances as $provenance)
                        <option value="{{ $provenance->id_provenance }}"
                            {{ $the->fk_id_provenance == $provenance->id_provenance ? 'selected' : '' }}>
                            {{ $provenance->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!--champs pour le Prix-->
            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Prix (CHF)</label>
                <input type="number" name="prix" value="{{ $the->prix }}"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
            </div>
            <!-- champ pour la date-->
            <div class="mb-6">
                <label class="block text-lg font-bold text-[#4A3428] mb-2">Date de récolte</label>
                <input 
                type="date" name="date_recolte" value="{{ \Carbon\Carbon::parse($the->date_recolte)->toDateString() }}"
                class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259']">
            </div>
        </div>
    </div>

    {{-- Boutons d'action en bas du formulaire --}}
    <div class="col-span-2 flex justify-between bg-[#967259] rounded-lg overflow-hidden">
        {{-- Bouton Annuler qui renvoie à la page de détails --}}
        <a href="{{ route('thes.show', $the) }}" 
            class="flex-1 py-4 text-center text-white hover:bg-[#7d6049] transition-colors border-r border-[#000000]">
            Annuler
        </a>
        {{-- Bouton pour sauvegarder les modifications --}}
        <button type="submit" class="flex-1 py-4 text-white hover:bg-[#7d6049] transition-colors">
            Enregistrer
        </button>
    </div>
</form>
@endsection