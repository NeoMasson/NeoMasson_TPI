<?php

namespace App\Http\Controllers;

use App\Models\The;
use App\Models\Type;
use App\Models\Variete;
use App\Models\Provenance;
use Illuminate\Http\Request;

/**
 * Contrôleur gérant toutes les opérations CRUD sur les thés
 * Permet la gestion complète du catalogue de thés, incluant leurs caractéristiques
 * et leurs relations avec les types, variétés et provenances
 */
class TheController extends Controller
{
    /**
     * Affiche la liste complète des thés
     * Charge également les relations (type, provenance, variété) pour éviter les requêtes N+1
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $thes = The::with(['type', 'provenance', 'variete'])->get();
        return view('thes.index', compact('thes'));
    }

    /**
     * Affiche les détails d'un thé spécifique
     * Inclut toutes les informations associées (type, provenance, variété)
     *
     * @param The $the Le thé à afficher (injection de modèle)
     * @return \Illuminate\View\View
     */
    public function show(The $the)
    {
        $the->load(['type', 'provenance', 'variete']);
        return view('thes.show', compact('the'));
    }

    /**
     * Affiche le formulaire d'édition d'un thé
     * Charge toutes les données nécessaires pour les menus déroulants
     *
     * @param The $the Le thé à éditer
     * @return \Illuminate\View\View
     */
    public function edit(The $the)
    {
        $the->load(['type', 'provenance', 'variete']);
        $types = Type::all();
        $varietes = Variete::all();
        $provenances = Provenance::all();
        
        return view('thes.edit', compact('the', 'types', 'varietes', 'provenances'));
    }

    /**
     * Met à jour les informations d'un thé existant
     * Valide les données entrées et met à jour toutes les relations
     *
     * @param Request $request Les données du formulaire
     * @param The $the Le thé à mettre à jour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, The $the)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'preparation' => 'required|string',
            'quantite' => 'required|numeric|min:0',
            'prix' => 'required|numeric|min:0',
            'date_recolte' => 'nullable|date',
            'type_id' => 'required|exists:t_type,id_type',
            'variete_id' => 'required|exists:t_variete,id_variete',
            'provenance_id' => 'required|exists:t_provenance,id_provenance',
        ]);

        $the->update([
            'description' => $validated['description'],
            'preparation' => $validated['preparation'],
            'quantite' => $validated['quantite'],
            'prix' => $validated['prix'],
            'date_recolte' => $validated['date_recolte'] ?? $the->date_recolte, // Conserve la date existante si non fournie
            'fk_id_type' => $validated['type_id'],
            'fk_id_variete' => $validated['variete_id'],
            'fk_id_provenance' => $validated['provenance_id'],
        ]);

        return redirect()->route('thes.show', $the)->with('success', 'Thé mis à jour avec succès');
    }

    /**
     * Supprime un thé du catalogue
     * Gère également la suppression des relations dans les listes
     *
     * @param The $the Le thé à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(The $the)
    {
        $the->listes()->detach(); // Supprime les relations dans la table pivot
        $the->delete();
        return redirect()->route('dashboard')->with('success', 'Thé supprimé avec succès');
    }

    /**
     * Affiche le formulaire de création d'un nouveau thé
     * Charge toutes les données nécessaires pour les menus déroulants
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $types = Type::all();
        $varietes = Variete::all();
        $provenances = Provenance::all();
        
        return view('thes.create', compact('types', 'varietes', 'provenances'));
    }

    /**
     * Enregistre un nouveau thé dans le catalogue
     * Valide toutes les données requises et crée les relations
     *
     * @param Request $request Les données du formulaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'preparation' => 'required|string',
            'quantite' => 'required|numeric|min:0',
            'prix' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type_id' => 'required|exists:t_type,id_type',
            'variete_id' => 'required|exists:t_variete,id_variete',
            'provenance_id' => 'required|exists:t_provenance,id_provenance',
        ]);

        $the = The::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'preparation' => $validated['preparation'],
            'quantite' => $validated['quantite'],
            'prix' => $validated['prix'],
            'date' => $validated['date'],
            'fk_id_type' => $validated['type_id'],
            'fk_id_variete' => $validated['variete_id'],
            'fk_id_provenance' => $validated['provenance_id'],
        ]);

        return redirect()->route('thes.show', $the)->with('success', 'Thé ajouté avec succès');
    }
}