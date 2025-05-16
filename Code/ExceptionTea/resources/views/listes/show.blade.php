@extends('layouts.app')

@section('header')
{{ $liste->nom }}
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <button onclick="window.history.back()" class="mb-4 flex items-center text-[#4A3428] hover:text-[#967259] transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </button>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h1 class="text-3xl font-bold text-[#4A3428]">{{ $liste->nom }}</h1>
        <div class="flex space-x-4">
            <form action="{{ route('listes.export', $liste) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 bg-[#967259] text-white rounded-lg hover:bg-[#7d6049] transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exporter en PDF
                </button>
            </form>
        </div>
    </div>

    <!-- Liste des thés -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($liste->thes as $the)
        <div class="bg-[#FFEFCD] rounded-lg shadow-lg p-6 relative" id="the-card-{{ $the->id_the }}">
            <button onclick="removeFromList({{ $liste->id_liste }}, {{ $the->id_the }})" 
                    class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <h3 class="text-xl font-semibold text-[#4A3428] mb-2">{{ $the->nom }}</h3>
            <p class="text-gray-600"><span class="font-medium">Type:</span> {{ $the->type->nom }}</p>
            <p class="text-gray-600"><span class="font-medium">Provenance:</span> {{ $the->provenance->nom }}</p>
            <p class="text-gray-600"><span class="font-medium">Variété:</span> {{ $the->variete->nom }}</p>
            <a href="{{ route('thes.show', $the) }}" class="mt-4 inline-block text-[#967259] hover:text-[#7d6049]">
                Voir les détails
            </a>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
function removeFromList(listeId, theId) {
    if (!confirm('Êtes-vous sûr de vouloir retirer ce thé de la liste ?')) {
        return;
    }

    fetch(`/listes/${listeId}/thes/${theId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const card = document.getElementById(`the-card-${theId}`);
        card.remove();
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de la suppression du thé de la liste');
    });
}
</script>
@endpush
@endsection