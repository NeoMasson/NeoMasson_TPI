@extends('layouts.app')

@section('header')
Toutes les listes
@endsection

@section('content')
<div class="p-6">
    <!-- Bouton d'ajout -->
    <div class="mb-6">
        <a href="{{ route('listes.create') }}" 
            class="inline-flex items-center px-4 py-2 bg-[#967259] text-white rounded-md hover:bg-[#7d6049] transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle liste
        </a>
    </div>

    <!-- Grille des listes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($listes as $liste)
            <div class="bg-[#FFEFCD] rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-[#4A3428]">{{ $liste->nom }}</h3>
                        <span class="text-sm text-gray-500">{{ $liste->date_creation->format('d/m/Y') }}</span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">
                        {{ $liste->thes_count }} thé(s)
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('listes.show', $liste) }}" 
                            class="text-[#967259] hover:text-[#7d6049] transition-colors">
                            Voir les détails →
                        </a>

                        <div class="flex space-x-2">
                            <a href="{{ route('listes.edit', $liste) }}" 
                                class="text-[#967259] hover:text-[#7d6049] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <form action="{{ route('listes.destroy', $liste) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette liste ?')"
                                    class="text-red-600 hover:text-red-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                <p class="text-xl">Vous n'avez pas encore créé de liste</p>
                <p class="mt-2">Commencez par créer une nouvelle liste pour organiser vos thés</p>
            </div>
        @endforelse
    </div>
</div>
@endsection