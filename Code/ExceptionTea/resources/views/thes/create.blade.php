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
            </div>            {{-- Champ pour le prix --}}            <div>
                <label for="prix" class="block text-lg font-bold text-[#4A3428] mb-2">Prix (CHF)</label>
                <div class="relative">                    <input type="number" 
                        id="prix" 
                        name="prix" 
                        step="0.01" 
                        min="0" 
                        max="99999.99"
                        pattern="^\d{1,5}(\.\d{0,2})?$"
                        oninput="validateNumber(this, 0, 99999.99)"
                        onchange="validateNumber(this, 0, 99999.99)"
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    <span class="text-sm text-gray-500 mt-1">Maximum: 99'999.99 CHF (2 décimales maximum)</span>
                </div>
            </div>
        </div>

        {{-- Colonne droite : Détails techniques --}}
        <div class="space-y-6">
            {{-- Zone de texte pour les instructions de préparation --}}
            <div>
                <label for="preparation" class="block text-lg font-bold text-[#4A3428] mb-2">Préparation</label>
                <textarea id="preparation" name="preparation" rows="4"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]"></textarea>
            </div>            {{-- Champ pour la quantité --}}            <div>
                <label for="quantite" class="block text-lg font-bold text-[#4A3428] mb-2">Quantité (pièces)</label>
                <div class="relative">                    <input type="number" 
                        id="quantite" 
                        name="quantite" 
                        min="0" 
                        max="999999"
                        step="1"
                        pattern="^\d+$"
                        oninput="validateNumber(this, 0, 999999)"
                        onchange="validateNumber(this, 0, 999999)"
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    <span class="text-sm text-gray-500 mt-1">Maximum: 999'999 pièces (entier seulement)</span>
                </div>
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
            <button type="button" onclick="toggleList('varieteList')" class="w-full flex justify-between items-center text-lg font-bold text-[#4A3428]">
                <span>Variété</span>
                <svg id="varieteIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="varieteList" class="hidden space-y-2 mt-4 max-h-48 overflow-y-auto">
                @foreach($varietes as $variete)
                    <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                        <label class="flex items-center space-x-2 flex-grow">
                            <input type="radio" name="variete_id" value="{{ $variete->id_variete }}" class="text-[#967259]">
                            <span>{{ $variete->nom }}</span>
                        </label>
                        <div class="flex space-x-2">
                <button type="button" onclick="event.preventDefault(); openEditModal('variete', {{ $variete->id_variete }}, '{{ $variete->nom }}')" 
                                class="text-[#967259] hover:text-[#7d6049]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                            <button type="button" onclick="event.preventDefault(); deleteItem('variete', {{ $variete->id_variete }})"
                                class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>            <button type="button" onclick="event.preventDefault(); openAddModal('variete')" 
                class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>

        {{-- Sélection de la provenance --}}
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <button type="button" onclick="toggleList('provenanceList')" class="w-full flex justify-between items-center text-lg font-bold text-[#4A3428]">
                <span>Provenance</span>
                <svg id="provenanceIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="provenanceList" class="hidden space-y-2 mt-4 max-h-48 overflow-y-auto">
                @foreach($provenances as $provenance)
                    <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                        <label class="flex items-center space-x-2 flex-grow">
                            <input type="radio" name="provenance_id" value="{{ $provenance->id_provenance }}" class="text-[#967259]">
                            <span>{{ $provenance->nom }}</span>
                        </label>
                        <div class="flex space-x-2">
                            <button type="button" onclick="openEditModal('provenance', {{ $provenance->id_provenance }}, '{{ $provenance->nom }}')"
                                class="text-[#967259] hover:text-[#7d6049]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                            <button type="button" onclick="deleteItem('provenance', {{ $provenance->id_provenance }})"
                                class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="openAddModal('provenance')"
                class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>

        {{-- Sélection du type --}}
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <button type="button" onclick="toggleList('typeList')" class="w-full flex justify-between items-center text-lg font-bold text-[#4A3428]">
                <span>Type</span>
                <svg id="typeIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="typeList" class="hidden space-y-2 mt-4 max-h-48 overflow-y-auto">
                @foreach($types as $type)
                    <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                        <label class="flex items-center space-x-2 flex-grow">
                            <input type="radio" name="type_id" value="{{ $type->id_type }}" class="text-[#967259]">
                            <span>{{ $type->nom }}</span>
                        </label>
                        <div class="flex space-x-2">
                            <button type="button" onclick="openEditModal('type', {{ $type->id_type }}, '{{ $type->nom }}')"
                                class="text-[#967259] hover:text-[#7d6049]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                            <button type="button" onclick="deleteItem('type', {{ $type->id_type }})"
                                class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="openAddModal('type')"
                class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>
    </div>

    {{-- Modal pour l'ajout/modification d'éléments --}}    <div id="itemModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" onclick="closeModal()">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" onclick="event.stopPropagation();">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Ajouter un élément</h3>
                <div class="mt-2 px-7 py-3">
                    <input type="hidden" id="modalAction" value="add">
                    <input type="hidden" id="modalType" value="">
                    <input type="hidden" id="modalItemId" value="">
                    <input type="text" id="modalItemName" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#967259]"
                        placeholder="Nom de l'élément">
                </div>
                <div class="items-center px-4 py-3">                    <button type="button" id="modalSaveBtn" 
                        class="px-4 py-2 bg-[#967259] text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-[#7d6049] focus:outline-none focus:ring-2 focus:ring-[#967259]">
                        Enregistrer
                    </button>
                    <button type="button" id="modalCancelBtn"
                        class="mt-3 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </button>
                </div>
            </div>
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
    </div>    {{-- Script pour la gestion des modals et des actions CRUD --}}
    @push('scripts')
    <script>        // Fonction de validation des nombres avec 2 décimales pour le prix
        function validateNumber(input, min, max) {
            let value = parseFloat(input.value);
            if (isNaN(value)) {
                input.value = min;
                return;
            }
            
            // Arrondir à 2 décimales pour le prix
            if (input.id === 'prix') {
                value = Math.round(value * 100) / 100;
            } else {
                value = Math.floor(value); // Nombres entiers pour la quantité
            }
            
            if (value < min) {
                value = min;
            } else if (value > max) {
                value = max;
            }
            
            input.value = value;
        }

        // Validation du formulaire avant soumission
        document.querySelector('form').addEventListener('submit', function(e) {
            const prix = document.getElementById('prix');
            const quantite = document.getElementById('quantite');
            let hasError = false;
            let errorMessage = '';            // Vérification du prix (DECIMAL(8,2) dans MySQL)
            if (prix.value === '' || isNaN(prix.value)) {
                errorMessage += 'Le prix doit être un nombre valide.\n';
                hasError = true;
            } else if (parseFloat(prix.value) < 0 || parseFloat(prix.value) > 99999.99) {
                errorMessage += 'Le prix doit être compris entre 0 et 99\'999.99 CHF.\n';
                hasError = true;
            }

            // Vérification de la quantité (INT dans MySQL)
            if (quantite.value === '' || isNaN(quantite.value)) {
                errorMessage += 'La quantité doit être un nombre valide.\n';
                hasError = true;
            } else if (parseInt(quantite.value) < 0 || parseInt(quantite.value) > 999999) {
                errorMessage += 'La quantité doit être comprise entre 0 et 999\'999 pièces.\n';
                hasError = true;
            }

            // Si erreur, empêcher la soumission et afficher le message
            if (hasError) {
                e.preventDefault();
                alert(errorMessage);
            }
        });

        // Script existant pour les modals
        // Modal elements
        const modal = document.getElementById('itemModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalAction = document.getElementById('modalAction');
        const modalType = document.getElementById('modalType');
        const modalItemId = document.getElementById('modalItemId');
        const modalItemName = document.getElementById('modalItemName');
        const modalSaveBtn = document.getElementById('modalSaveBtn');
        const modalCancelBtn = document.getElementById('modalCancelBtn');

        // Ouvrir le modal pour ajouter un élément
        function openAddModal(type) {
            modalTitle.textContent = `Ajouter un ${type}`;
            modalAction.value = 'add';
            modalType.value = type;
            modalItemId.value = '';
            modalItemName.value = '';
            modal.classList.remove('hidden');
        }

        // Ouvrir le modal pour modifier un élément
        function openEditModal(type, id, name) {
            modalTitle.textContent = `Modifier le ${type}`;
            modalAction.value = 'edit';
            modalType.value = type;
            modalItemId.value = id;
            modalItemName.value = name;
            modal.classList.remove('hidden');
        }

        // Fermer le modal
        function closeModal() {
            modal.classList.add('hidden');
        }        // Supprimer un élément
        async function deleteItem(type, id) {
            if (!confirm('Voulez-vous vraiment supprimer cet élément ?')) return;

            const deleteBtn = event.target;
            const originalText = deleteBtn.textContent;

            try {
                deleteBtn.disabled = true;
                deleteBtn.textContent = 'Suppression...';

                const response = await fetch(`/api/${type}s/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showNotification(data.message || 'Élément supprimé avec succès');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'Une erreur est survenue lors de la suppression', 'error');
                    deleteBtn.disabled = false;
                    deleteBtn.textContent = originalText;
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de la communication avec le serveur', 'error');
                deleteBtn.disabled = false;
                deleteBtn.textContent = originalText;
            }
        }

        // Fonction pour basculer l'affichage des listes
        function toggleList(listId) {
            const list = document.getElementById(listId);
            const icon = document.getElementById(listId.replace('List', 'Icon'));
            
            list.classList.toggle('hidden');
            if (list.classList.contains('hidden')) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }
        }

        // Configuration des événements
        modalCancelBtn.onclick = closeModal;                // Fonction pour afficher une notification
        function showNotification(message, type = 'success') {
            const notif = document.createElement('div');
            notif.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white transition-all duration-300 transform translate-y-0 opacity-100 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notif.textContent = message;
            document.body.appendChild(notif);

            // Animation de disparition
            setTimeout(() => {
                notif.style.opacity = '0';
                notif.style.transform = 'translateY(100%)';
                setTimeout(() => notif.remove(), 300);
            }, 3000);
        }

        modalSaveBtn.onclick = async (e) => {
            e.preventDefault();
            e.stopPropagation();
            const type = modalType.value;
            const action = modalAction.value;
            const id = modalItemId.value;
            const name = modalItemName.value;

            if (!name.trim()) {
                showNotification('Veuillez entrer un nom', 'error');
                return;
            }

            let url;
            switch(type) {
                case 'variete':
                    url = action === 'add' ? '/api/varietes' : `/api/varietes/${id}`;
                    break;
                case 'provenance':
                    url = action === 'add' ? '/api/provenances' : `/api/provenances/${id}`;
                    break;
                case 'type':
                    url = action === 'add' ? '/api/types' : `/api/types/${id}`;
                    break;
                default:
                    showNotification('Type invalide', 'error');
                    return;
            }
            const method = action === 'add' ? 'POST' : 'PUT';

            try {
                modalSaveBtn.disabled = true;
                modalSaveBtn.textContent = 'Enregistrement...';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ nom: name })
                });

                const data = await response.json();

                if (response.ok) {
                    showNotification(data.message || 'Enregistré avec succès');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'Une erreur est survenue', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de la communication avec le serveur', 'error');
            } finally {
                modalSaveBtn.disabled = false;
                modalSaveBtn.textContent = 'Enregistrer';
            }
        };

        // Fermer le modal en cliquant en dehors
        window.onclick = (event) => {
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
    @endpush

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