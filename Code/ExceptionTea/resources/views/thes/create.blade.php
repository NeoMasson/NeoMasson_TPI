@extends('layouts.app')

<!-- Définition du titre de la page dans l'en-tête -->
@section('header')
    Ajouter un Thé
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
                        @case(strpos($error, 'The nom field is required') !== false)
                            Le nom du thé est obligatoire
                            @break
                        @case(strpos($error, 'The description field is required') !== false)
                            Une description est requise
                            @break
                        @case(strpos($error, 'The preparation field is required') !== false)
                            Les instructions de préparation sont nécessaires
                            @break
                        @case(strpos($error, 'The quantite field is required') !== false)
                            La quantité est obligatoire
                            @break
                        @case(strpos($error, 'The prix field is required') !== false)
                            Le prix doit être indiqué
                            @break
                        @case(strpos($error, 'The date field is required') !== false)
                            La date de récolte est obligatoire
                            @break
                        @case(strpos($error, 'The type_id field is required') !== false)
                            Veuillez sélectionner un type de thé
                            @break
                        @case(strpos($error, 'The variete_id field is required') !== false)
                            Veuillez sélectionner une variété de thé
                            @break
                        @case(strpos($error, 'The provenance_id field is required') !== false)
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
<!-- Formulaire principal avec mise en page responsive -->
<form action="{{ route('thes.store') }}" method="POST" class="max-w-4xl mx-auto p-6">
    <!-- Token CSRF pour la sécurité -->
    @csrf
    <!-- Grille principale - une colonne sur mobile, deux sur tablette/desktop -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Colonne gauche : Informations générales -->
        <div class="space-y-6">
            <!-- Champ pour le nom du thé -->
            <div>
                <label for="nom" class="block text-lg font-bold text-[#4A3428] mb-2">Nom</label>
                <div class="relative">
                    <input type="text" id="nom" name="nom" 
                        placeholder="ex. Matcha, Earl grey, etc..."
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                </div>
            </div>

            <!-- Zone de texte pour la description -->
            <div>
                <label for="description" class="block text-lg font-bold text-[#4A3428] mb-2">Description</label><textarea id="description" name="description" rows="4"
                    maxlength="1000"
                    style="max-height: 250px; min-height: 100px; resize: vertical;"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259] overflow-y-auto"
                    onkeyup="updateCharCount(this, 'descriptionCount')"></textarea>
                <div class="text-sm text-gray-500 mt-1">
                    <span id="descriptionCount">0</span>/1000 caractères
                </div>
            </div>            

            <!-- Champ pour le prix -->            
            <div>
                <label for="prix" class="block text-lg font-bold text-[#4A3428] mb-2">Prix (CHF)</label>
                <div class="relative">                    
                    <input type="number" 
                        id="prix" 
                        name="prix" 
                        step="1" 
                        min="0" 
                        max="9999.99"
                        pattern="^\d{1,4}(\.\d{0,2})?$"
                        oninput="validateNumber(this, 0, 9999.99)"
                        onchange="validateNumber(this, 0, 9999.99)"
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    <span class="text-sm text-gray-500 mt-1">Maximum: 9'999.99 CHF (2 décimales maximum)</span>
                </div>
            </div>
        </div>        <!-- Colonne de droite -->
        <div class="space-y-6">

            <!-- Zone de texte pour les instructions de préparation -->
            <div>
                <label for="preparation" class="block text-lg font-bold text-[#4A3428] mb-2">Préparation</label>
                <textarea id="preparation" name="preparation" rows="4"
                    maxlength="500"
                    style="max-height: 250px; min-height: 100px; resize: vertical;"
                    class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259] overflow-y-auto"
                    onkeyup="updateCharCount(this, 'preparationCount')"></textarea>
                <div class="text-sm text-gray-500 mt-1">
                    <span id="preparationCount">0</span>/500 caractères
                </div>
            </div>            

            <!-- Champ pour la quantité -->
            <div>
                <label for="quantite" class="block text-lg font-bold text-[#4A3428] mb-2">Quantité (pièces)</label>
                <div class="relative">                    
                    <input type="number" 
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

            <!-- Sélecteur de date avec icône -->
            <div>
                <label for="date" class="block text-lg font-bold text-[#4A3428] mb-2">Date de récolte</label>
                <div class="relative">
                    <input type="date" id="date" name="date"
                        class="w-full bg-input rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#967259]">
                    <span class="absolute right-2 top-1/2 transform -translate-y-1/2">
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des listes déroulantes pour les catégorisations -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Sélection de la variété -->
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <button type="button" onclick="toggleList('varieteList')" class="w-full flex justify-between items-center text-lg font-bold text-[#4A3428]">
                <span>Variété</span>
                <svg id="varieteIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <!--faire en sorte que la scrollbar de la liste ai une couleur qui va avec le thème (optionel si tout doit absolument être en Tailwind)-->
            <style>
                .scrollbar-thin::-webkit-scrollbar {
                    width: 8px;
                }
                .scrollbar-thin::-webkit-scrollbar-thumb {
                    background-color: #967259;
                    border-radius: 4px;
                }
            </style>

            <!-- Liste des variétés -->
            <div id="varieteList" class="hidden space-y-2 mt-4 max-h-48 overflow-y-auto scrollbar-thin">
                @foreach($varietes as $variete)
                    <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                        <label class="flex items-center space-x-2 flex-grow">
                            <input type="radio" name="variete_id" value="{{ $variete->id_variete }}" class="text-[#967259]">
                            <span>{{ $variete->nom }}</span>
                        </label>
                        <div class="flex space-x-2">
                <button type="button" onclick="event.preventDefault(); openEditpopup('variete', {{ $variete->id_variete }}, '{{ $variete->nom }}')" 
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
            </div>            <button type="button" onclick="event.preventDefault(); openAddpopup('variete')" 
                class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>

        <!-- Sélection de la provenance -->
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <button type="button" onclick="toggleList('provenanceList')" class="w-full flex justify-between items-center text-lg font-bold text-[#4A3428]">
                <span>Provenance</span>
                <svg id="provenanceIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="provenanceList" class="hidden space-y-2 mt-4 max-h-48 overflow-y-auto scrollbar-thin">
                @foreach($provenances as $provenance)
                    <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                        <label class="flex items-center space-x-2 flex-grow">
                            <input type="radio" name="provenance_id" value="{{ $provenance->id_provenance }}" class="text-[#967259]">
                            <span>{{ $provenance->nom }}</span>
                        </label>
                        <div class="flex space-x-2">
                            <button type="button" onclick="openEditpopup('provenance', {{ $provenance->id_provenance }}, '{{ $provenance->nom }}')"
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
            <button type="button" onclick="openAddpopup('provenance')"
                class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>

        <!-- Sélection du type -->
        <div class="bg-[#F4E5C3] rounded-lg p-4">
            <button type="button" onclick="toggleList('typeList')" class="w-full flex justify-between items-center text-lg font-bold text-[#4A3428]">
                <span>Type</span>
                <svg id="typeIcon" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="typeList" class="hidden space-y-2 mt-4 max-h-48 overflow-y-auto scrollbar-thin">
                @foreach($types as $type)
                    <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                        <label class="flex items-center space-x-2 flex-grow">
                            <input type="radio" name="type_id" value="{{ $type->id_type }}" class="text-[#967259]">
                            <span>{{ $type->nom }}</span>
                        </label>
                        <div class="flex space-x-2">
                            <button type="button" onclick="openEditpopup('type', {{ $type->id_type }}, '{{ $type->nom }}')"
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
            <button type="button" onclick="openAddpopup('type')"
                class="mt-4 w-full bg-[#967259] text-white px-4 py-2 rounded hover:bg-[#7d6049]">
                Ajouter un élément
            </button>
        </div>
    </div>
        <!-- Pop-up pour l'ajout/modification d'éléments -->
    <div id="itempopup" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" onclick="closepopup()">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" onclick="event.stopPropagation();">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="popupTitle">Ajouter un élément</h3>
                <div class="mt-2 px-7 py-3">
                    <input type="hidden" id="popupAction" value="add">
                    <input type="hidden" id="popupType" value="">
                    <input type="hidden" id="popupItemId" value="">
                    <input type="text" id="popupItemName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#967259]" placeholder="Nom de l'élément">
                </div>
                <div class="items-center px-4 py-3">                    
                    <button type="button" id="popupSaveBtn" 
                        class="px-4 py-2 bg-[#967259] text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-[#7d6049] focus:outline-none focus:ring-2 focus:ring-[#967259]">
                        Enregistrer
                    </button>
                    <button type="button" id="popupCancelBtn" onclick="closepopup()"
                        class="mt-3 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons d'action en bas du formulaire -->
    <div class="mt-8 flex flex-col sm:flex-row justify-between sm:space-x-4 space-y-4 sm:space-y-0">
        <!-- Bouton pour réinitialiser le formulaire -->
        <button type="reset" class="w-full bg-[#FFEFCD] text-[#4A3428] px-8 py-3 rounded-lg hover:bg-[#F4E5C3] transition duration-200" onclick="document.getElementById('descriptionCount').textContent = '0'; document.getElementById('preparationCount').textContent = '0';">
            Effacer
        </button>
        <!-- Bouton pour soumettre le formulaire -->
        <button type="submit" name="action" value="submit" class="w-full bg-[#967259] text-white px-8 py-3 rounded-lg hover:bg-[#7d6049] transition duration-200">
            Ajouter
        </button>
    </div>
</form>

    <!-- Scripts pour la gestion des validations et interactions -->
    @push('scripts')
    <script>
        /**
         * Met à jour le compteur de caractères pour les champs textarea
         * @param {HTMLTextAreaElement} textarea - Le champ textarea à surveiller
         * @param {string} counterId - L'ID de l'élément affichant le nombre de caractères
         */
        function updateCharCount(textarea, counterId) {
            const counter = document.getElementById(counterId);
            const currentLength = textarea.value.length;
            const maxLength = textarea.getAttribute('maxlength');
            counter.textContent = currentLength;
            
            // Change la couleur si on approche de la limite
            if (currentLength >= maxLength * 0.9) {
                counter.classList.add('text-red-500');
            } else {
                counter.classList.remove('text-red-500');
            }
        }

        /**
         * Fonction de validation des nombres pour les champs prix et quantité
         * @param {HTMLInputElement} input - L'élément input à valider
         * @param {number} min - Valeur minimum autorisée
         * @param {number} max - Valeur maximum autorisée
         */
        function validateNumber(input, min, max) {
            let value = parseFloat(input.value);
            if (isNaN(value)) {
                input.value = min;
                return;
            }
            
            // Traitement spécifique selon le type de champ
            if (input.id === 'prix') {
                // Arrondir à 2 décimales pour le prix (format DECIMAL(8,2))
                value = Math.round(value * 100) / 100;
            } else {
                // Nombres entiers pour la quantité
                value = Math.floor(value);
            }
            
            // Appliquer les limites min/max
            value = Math.max(min, Math.min(max, value));
            input.value = value;
        }

        // Validation du formulaire avant soumission
        document.querySelector('form').addEventListener('submit', function(e) {
            // Ne valider que si c'est une soumission du formulaire (pas pour la déconnexion)
            if (e.submitter && e.submitter.getAttribute('name') !== 'action') {
                return true;
            }
            // Récupérer les éléments du formulaire
            const prix = document.getElementById('prix');
            const quantite = document.getElementById('quantite');
            let hasError = false;
            let errorMessage = '';

            // Validation du prix (DECIMAL(8,2) dans MySQL)
            if (prix.value === '' || isNaN(prix.value)) {
                hasError = true;
                errorMessage = 'Le prix doit être un nombre valide.';
            } else if (parseFloat(prix.value) < 0 || parseFloat(prix.value) > 9999.99) {
                hasError = true;
                errorMessage = 'Le prix doit être entre 0 et 9999.99 CHF.';
            }

            // Validation de la quantité (INT dans MySQL)
            if (quantite.value === '' || isNaN(quantite.value)) {
                hasError = true;
                errorMessage += (errorMessage ? '\n' : '') + 'La quantité doit être un nombre valide.';
            } else if (parseInt(quantite.value) < 0 || parseInt(quantite.value) > 999999) {
                hasError = true;
                errorMessage += (errorMessage ? '\n' : '') + 'La quantité doit être entre 0 et 999999.';
            }

            // Arrêter la soumission si des erreurs sont trouvées
            if (hasError) {
                e.preventDefault();
                alert(errorMessage);
            }
        });

        // Scripts existants pour les Pop-ups
        // Pop-up elements
        const popup = document.getElementById('itempopup');
        const popupTitle = document.getElementById('popupTitle');
        const popupAction = document.getElementById('popupAction');
        const popupType = document.getElementById('popupType');
        const popupItemId = document.getElementById('popupItemId');
        const popupItemName = document.getElementById('popupItemName');
        const popupSaveBtn = document.getElementById('popupSaveBtn');
        const popupCancelBtn = document.getElementById('popupCancelBtn');

        // Ouvrir le Pop-up pour ajouter un élément
        function openAddpopup(type) {
            popupTitle.textContent = `Ajouter un ${type}`;
            popupAction.value = 'add';
            popupType.value = type;
            popupItemId.value = '';
            popupItemName.value = '';
            popup.classList.remove('hidden');
        }

        // Ouvrir le Pop-up pour modifier un élément
        function openEditpopup(type, id, name) {
            popupTitle.textContent = `Modifier le ${type}`;
            popupAction.value = 'edit';
            popupType.value = type;
            popupItemId.value = id;
            popupItemName.value = name;
            popup.classList.remove('hidden');
        }

        // Fermer le Pop-up
        function closepopup() {
            popup.classList.add('hidden');
        }        /**
         * Mise à jour asynchrone d'une liste (type, variété ou provenance)
         * Cette fonction utilise l'API Fetch pour :
         * 1. Récupérer la liste mise à jour depuis le serveur
         * 2. Régénérer le HTML de la liste avec les nouvelles données
         * 3. Conserver la sélection actuelle si elle existe encore
         * 
         * @param {string} type - Le type de liste à mettre à jour ('type', 'variete' ou 'provenance')
         */
        async function updateList(type) {
            try {
                const response = await fetch(`/api/${type}s/list`);
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des données');
                }
                
                const items = await response.json();
                const listContainer = document.getElementById(`${type}List`);
                const selectedValue = document.querySelector(`input[name="${type}_id"]:checked`)?.value;
                
                let html = '';
                items.forEach(item => {
                    const itemId = item[`id_${type}`];
                    html += `
                        <div class="flex justify-between items-center bg-[#FFEFCD] rounded p-2">
                            <label class="flex items-center space-x-2 flex-grow">
                                <input type="radio" name="${type}_id" value="${itemId}" 
                                    ${selectedValue == itemId ? 'checked' : ''} 
                                    class="text-[#967259]">
                                <span>${item.nom}</span>
                            </label>
                            <div class="flex space-x-2">
                                <button type="button" onclick="openEditpopup('${type}', ${itemId}, '${item.nom}')" 
                                    class="text-[#967259] hover:text-[#7d6049]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteItem('${type}', ${itemId})"
                                    class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                });
                
                listContainer.innerHTML = html;
            } catch (error) {
                console.error('Erreur lors de la mise à jour de la liste:', error);
                showNotification('Erreur lors de la mise à jour de la liste', 'error');
            }
        }

        /**
         * Gestion de la suppression d'un élément
         * Cette fonction :
         * 1. Demande confirmation avant suppression
         * 2. Envoie une requête DELETE au serveur
         * 3. Met à jour la liste correspondante si la suppression réussit
         * 4. Affiche une notification de succès ou d'erreur
         * 
         * @param {string} type - Le type d'élément à supprimer
         * @param {number} id - L'identifiant de l'élément
         */
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

                const data = await response.json();                if (response.ok) {
                    await updateList(type);
                    showNotification(data.message || 'Élément supprimé avec succès');
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

        /**
         * Gestionnaire de clic pour le bouton de sauvegarde du Pop-up
         * Cette fonction gère :
         * 1. La validation des données entrées
         * 2. L'envoi des données au serveur (création ou modification)
         * 3. La mise à jour de la liste concernée
         * 4. L'affichage des notifications de succès ou d'erreur
         * 5. La fermeture du Pop-up après succès
         */
        popupSaveBtn.onclick = async (e) => {
            e.preventDefault();
            e.stopPropagation();
            const type = popupType.value;
            const action = popupAction.value;
            const id = popupItemId.value;
            const name = popupItemName.value;

            if (!name.trim()) {
                showNotification('Veuillez entrer un nom', 'error');
                return;
            }

            try {
                popupSaveBtn.disabled = true;
                const method = action === 'add' ? 'POST' : 'PUT';
                const url = action === 'add' ? `/api/${type}s` : `/api/${type}s/${id}`;
                
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
                    await updateList(type);
                    showNotification(data.message || `${type} ${action === 'add' ? 'ajouté' : 'modifié'} avec succès`);
                    closepopup();
                } else {
                    showNotification(data.message || 'Une erreur est survenue', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de la communication avec le serveur', 'error');
            } finally {
                popupSaveBtn.disabled = false;
            }
        };

        // Fermer le Pop-up en cliquant en dehors
        window.onclick = (event) => {
            if (event.target === popup) {
                closepopup();
            }
        };
        /**
         * Affiche une notification à l'utilisateur
         * @param {string} message - Le message à afficher
         * @param {string} type - Le type de notification ('success' ou 'error')
         */
        function showNotification(message, type = 'success') {
            // Logique pour afficher la notification
            alert(message);
        }
    </script>
    @endpush
@endsection