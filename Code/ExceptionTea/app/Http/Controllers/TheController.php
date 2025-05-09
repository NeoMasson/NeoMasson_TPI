<?php

namespace App\Http\Controllers;

use App\Models\The;
use App\Models\Type;
use App\Models\Variete;
use App\Models\Provenance;
use Illuminate\Http\Request;

class TheController extends Controller
{
    /**
     * Affiche la liste des thés
     */
    public function index()
    {
        $thes = The::with(['type', 'provenance', 'variete'])->get();
        return view('thes.index', compact('thes'));
    }

    /**
     * Affiche les détails d'un thé spécifique
     */
    public function show(The $the)
    {
        $the->load(['type', 'provenance', 'variete']);
        return view('thes.show', compact('the'));
    }

    /**
     * Affiche le formulaire d'édition d'un thé
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
     * Met à jour un thé
     */
    public function update(Request $request, The $the)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'preparation' => 'required|string',
            'quantite' => 'required|numeric|min:0',
            'type_id' => 'required|exists:t_type,id_type',
            'variete_id' => 'required|exists:t_variete,id_variete',
            'provenance_id' => 'required|exists:t_provenance,id_provenance',
        ]);

        $the->update([
            'description' => $validated['description'],
            'preparation' => $validated['preparation'],
            'quantite' => $validated['quantite'],
            'fk_id_type' => $validated['type_id'],
            'fk_id_variete' => $validated['variete_id'],
            'fk_id_provenance' => $validated['provenance_id'],
        ]);

        return redirect()->route('thes.show', $the)->with('success', 'Thé mis à jour avec succès');
    }

    /**
     * Supprime un thé
     */
    public function destroy(The $the)
    {
        $the->listes()->detach(); // Supprime les relations dans la table pivot
        $the->delete();
        return redirect()->route('dashboard')->with('success', 'Thé supprimé avec succès');
    }

    /**
     * Affiche le formulaire de création d'un thé
     */
    public function create()
    {
        $types = Type::all();
        $varietes = Variete::all();
        $provenances = Provenance::all();
        
        return view('thes.create', compact('types', 'varietes', 'provenances'));
    }

    /**
     * Enregistre un nouveau thé
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