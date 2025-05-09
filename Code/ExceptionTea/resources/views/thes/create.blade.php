@extends('layouts.app')

{{-- Définition du titre de la page dans l'en-tête --}}
@section('header')
    Ajouter un Thé
@endsection

@section('content')
{{-- Formulaire principal avec mise en page responsive --}}
<form action="{{ route('thes.store') }}" method="POST" class="max-w-4xl mx-auto p-6">
    {{-- Token CSRF pour la sécurité --}}
    @csrf
    
    {{-- Grille principale divisée en deux colonnes --}}
    <div class="grid grid-cols-2 gap-6">
        {{-- Colonne gauche : Informations générales --}}
        <div class="space-y-6">
            {{-- Champ pour le nom du thé --}}
            <div>
                <label for="nom" class="block text-lg font-bold text-[#4A3428] mb-2">Nom</label>
                <div class="relative">
                    <input type="text" id="nom" name="nom" 
                        placeholder="e.g. Apple, Banana, etc."
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                </div>
            </div>

            {{-- Zone de texte pour la description --}}
            <div>
                <label for="description" class="block text-lg font-bold text-[#4A3428] mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]"></textarea>
            </div>

            {{-- Champ pour le prix --}}
            <div>
                <label for="prix" class="block text-lg font-bold text-[#4A3428] mb-2">Prix</label>
                <input type="number" id="prix" name="prix" step="0.01"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
            </div>
        </div>

        {{-- Colonne droite : Détails techniques --}}
        <div class="space-y-6">
            {{-- Zone de texte pour les instructions de préparation --}}
            <div>
                <label for="preparation" class="block text-lg font-bold text-[#4A3428] mb-2">Préparation</label>
                <textarea id="preparation" name="preparation" rows="4"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]"></textarea>
            </div>

            {{-- Champ pour la quantité --}}
            <div>
                <label for="quantite" class="block text-lg font-bold text-[#4A3428] mb-2">Quantité</label>
                <input type="number" id="quantite" name="quantite"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
            </div>

            {{-- Sélecteur de date avec icône --}}
            <div>
                <label for="date" class="block text-lg font-bold text-[#4A3428] mb-2">Date</label>
                <div class="relative">
                    <input type="date" id="date" name="date"
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    <span class="absolute right-2 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Section des listes déroulantes pour les catégorisations --}}
    <div class="mt-8 grid grid-cols-3 gap-6">
        {{-- Sélection de la variété --}}
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <h3 class="text-lg font-bold text-[#4A3428] mb-4">Variété</h3>
            <select name="variete_id" class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                @foreach($varietes as $variete)
                    <div class="flex justify-between items-center">
                        <option value="{{ $variete->id_variete }}">{{ $variete->nom }}</option>
                    </div>
                @endforeach
            </select>
            <button type="button" class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>

        {{-- Sélection de la provenance --}}
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <h3 class="text-lg font-bold text-[#4A3428] mb-4">Provenance</h3>
            <select name="provenance_id" class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                @foreach($provenances as $provenance)
                    <div class="flex justify-between items-center">
                        <option value="{{ $provenance->id_provenance }}">{{ $provenance->nom }}</option>
                    </div>
                @endforeach
            </select>
            <button type="button" class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>

        {{-- Sélection du type --}}
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <h3 class="text-lg font-bold text-[#4A3428] mb-4">Type</h3>
            <select name="type_id" class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                @foreach($types as $type)
                    <div class="flex justify-between items-center">
                        <option value="{{ $type->id_type }}">{{ $type->nom }}</option>
                    </div>
                @endforeach
            </select>
            <button type="button" class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>
    </div>

    {{-- Boutons d'action en bas du formulaire --}}
    <div class="mt-8 flex justify-between space-x-4">
        {{-- Bouton pour réinitialiser le formulaire --}}
        <button type="reset" class="w-full bg-[#FFEFCD] text-[#4A3428] px-8 py-3 rounded-lg hover:bg-[#F4E5C3] transition duration-200">
            Effacer
        </button>
        {{-- Bouton pour soumettre le formulaire --}}
        <button type="submit" class="w-full bg-[#967259] text-white px-8 py-3 rounded-lg hover:bg-[#7d6049] transition duration-200">
            Ajouter
        </button>
    </div>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
@endsection