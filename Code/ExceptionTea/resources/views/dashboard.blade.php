@extends('layouts.app')

@section('header')
Tous les Thés
@endsection

@section('content')
<div class="space-y-4">
    <!-- Filtres -->
    <div class="bg-[#967259] p-4 rounded-lg">
        <div class="flex flex-wrap gap-4">
            <input type="text" id="searchInput" placeholder="Rechercher un thé..." 
                class="px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7d6049] bg-white">
            
            <select id="typeFilter" class="px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7d6049] bg-white">
                <option value="">Tous les types</option>
                @foreach($types as $type)
                    <option value="{{ $type->nom }}">{{ $type->nom }}</option>
                @endforeach
            </select>

            <select id="provenanceFilter" class="px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#7d6049] bg-white">
                <option value="">Toutes les provenances</option>
                @foreach($provenances as $provenance)
                    <option value="{{ $provenance->nom }}">{{ $provenance->nom }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Tableau des thés -->
    <div class="bg-[#FFEFCD] rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-[#967259]" id="teasTable">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('teasTable');
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const provenanceFilter = document.getElementById('provenanceFilter');
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    let sortDirection = {};

    // Fonction de tri
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

        tbody.innerHTML = '';
        sortedRows.forEach(row => tbody.appendChild(row));
    }

    // Gestionnaires d'événements pour le tri
    table.querySelectorAll('th[data-sort]').forEach(th => {
        th.addEventListener('click', () => {
            const column = th.dataset.sort;
            sortTable(column);
        });
    });

    // Fonction de filtrage
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value.toLowerCase();
        const selectedProvenance = provenanceFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.children[0].textContent.toLowerCase();
            const type = row.children[1].textContent.toLowerCase();
            const provenance = row.children[2].textContent.toLowerCase();

            const matchesSearch = name.includes(searchTerm);
            const matchesType = !selectedType || type === selectedType;
            const matchesProvenance = !selectedProvenance || provenance === selectedProvenance;

            row.style.display = (matchesSearch && matchesType && matchesProvenance) ? '' : 'none';
        });
    }

    // Gestionnaires d'événements pour le filtrage
    searchInput.addEventListener('input', filterTable);
    typeFilter.addEventListener('change', filterTable);
    provenanceFilter.addEventListener('change', filterTable);
});
</script>
@endpush
@endsection
