@extends('layouts.app')

@section('header')
Tous les Thés
@endsection

@section('content')
<div class="space-y-4">
    <!-- Section des filtres de recherche -->
    <div class="bg-[#967259] p-4 rounded-lg">
        <div class="flex flex-col sm:flex-row w-full gap-4">

            <!-- Barre de recherche textuelle -->
            <input type="text" id="searchInput" placeholder="Rechercher un thé..." 
                class="w-full sm:w-48 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7d6049] bg-input">
            
            <!-- Filtre par type de thé -->
            <select id="typeFilter" class="w-full sm:w-48 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7d6049] bg-input">
                <option value="">Filtrer types</option>
                @foreach($types as $type)
                    <option value="{{ $type->nom }}">{{ $type->nom }}</option>
                @endforeach
            </select>

            <!-- Filtre par provenance -->
            <select id="provenanceFilter" class="w-full sm:w-48 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7d6049] bg-input">
                <option value="">Filtrer provenances</option>
                @foreach($provenances as $provenance)
                    <option value="{{ $provenance->nom }}">{{ $provenance->nom }}</option>
                @endforeach
            </select>
            
            <!-- Bouton de réinitialisation des filtres -->
            <button id="resetFiltersButton" class="w-full sm:w-auto mt-2 sm:mt-0 px-4 py-2 bg-[#4A3428] text-white rounded-md hover:bg-[#7d6049] transition duration-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Réinitialiser les filtres
            </button>
        </div>
    </div>

    <!-- Tableau principal des thés - avec scroll horizontal amélioré pour mobile -->
    <div class="bg-[#FFEFCD] rounded-lg shadow overflow-hidden relative">
        <div class="overflow-x-auto pb-2 w-full">
            <!-- Indicateur de défilement horizontal sur mobile -->
            <div class="sm:hidden text-center text-xs text-gray-500 italic py-1">
                Faites glisser pour voir plus de colonnes →
            </div>
        <table class="min-w-full divide-y divide-[#967259]" id="teasTable">
            <!-- En-tête du tableau avec colonnes triables -->
            <thead class="bg-[#967259]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider cursor-pointer" data-sort="nom">
                        Nom
                        <span class="ml-1">↕</span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider cursor-pointer" data-sort="type">
                        Type
                        <span class="ml-1">↕</span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider cursor-pointer" data-sort="provenance">
                        Provenance
                        <span class="ml-1">↕</span>
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Détails
                    </th>
                </tr>
            </thead>
            <!-- Corps du tableau avec les données des thés -->
            <tbody class="bg-[#FFEFCD] divide-y divide-[#967259]">
                @foreach($thes as $the)
                    <tr class="hover:bg-[#F4E5C3] transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $the->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $the->type->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $the->provenance->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            <a href="{{ route('thes.show', $the) }}" class="text-[#967259] hover:text-[#7d6049]">
                                🔍
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
/* Script pour la gestion du tableau interactif */
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des éléments DOM
    const table = document.getElementById('teasTable');
    const searchInput = document.getElementById('searchInput');
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const typeFilter = document.getElementById('typeFilter');
    const provenanceFilter = document.getElementById('provenanceFilter');

    let sortDirection = {};

    /**
     * Fonction de tri du tableau
     * @param {string} column - La colonne sur laquelle effectuer le tri
     */
    function sortTable(column) {
        const index = {
            'nom': 0,
            'type': 1,
            'provenance': 2
        }[column];

        sortDirection[column] = !sortDirection[column];
        
        const tbody = table.querySelector('tbody');
        const sortedRows = rows.sort((a, b) => {
            const aValue = a.children[index].textContent.trim().toLowerCase();
            const bValue = b.children[index].textContent.trim().toLowerCase();
            return sortDirection[column] ? 
                aValue.localeCompare(bValue) : 
                bValue.localeCompare(aValue);
        });

        // Mise à jour du tableau avec les lignes triées
        tbody.innerHTML = '';
        sortedRows.forEach(row => tbody.appendChild(row));
    }

    // Ajout des écouteurs d'événements pour le tri
    table.querySelectorAll('th[data-sort]').forEach(th => {
        th.addEventListener('click', () => {
            const column = th.dataset.sort;
            sortTable(column);
        });
    });

    /**
     * Fonction de filtrage du tableau
     * Applique les filtres de recherche, type et provenance
     */
    /**
     * Réinitialise tous les filtres et actualise le tableau
     */
    function resetFilters() {
        searchInput.value = '';
        typeFilter.selectedIndex = 0;
        provenanceFilter.selectedIndex = 0;
        filterTable();
    }

    // Ajout de l'écouteur d'événement pour le bouton de réinitialisation
    document.getElementById('resetFiltersButton').addEventListener('click', resetFilters);

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value.toLowerCase();
        const selectedProvenance = provenanceFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.children[0].textContent.toLowerCase();
            const type = row.children[1].textContent.toLowerCase();
            const provenance = row.children[2].textContent.toLowerCase();

            // Application des différents filtres
            const matchesSearch = name.includes(searchTerm);
            const matchesType = !selectedType || type === selectedType;
            const matchesProvenance = !selectedProvenance || provenance === selectedProvenance;

            // Affichage/masquage des lignes selon les filtres
            row.style.display = (matchesSearch && matchesType && matchesProvenance) ? '' : 'none';
        });
    }

    // Ajout des écouteurs d'événements pour le filtrage
    searchInput.addEventListener('input', filterTable);
    typeFilter.addEventListener('change', filterTable);
    provenanceFilter.addEventListener('change', filterTable);
});
</script>
@endpush
@endsection
