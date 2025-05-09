<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\The;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ListeController extends Controller
{
    /**
     * Affiche la liste des listes de thés
     */
    public function index()
    {
        $listes = Liste::withCount('thes')->orderBy('date_creation', 'desc')->get();
        return view('listes.index', compact('listes'));
    }

    /**
     * Affiche le formulaire de création d'une liste
     */
    public function create()
    {
        return view('listes.create');
    }

    /**
     * Enregistre une nouvelle liste
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Liste::create([
            'nom' => $validated['nom'],
            'date_creation' => now(),
        ]);

        return redirect()->route('listes.index')
            ->with('success', 'Liste créée avec succès');
    }

    /**
     * Affiche une liste spécifique
     */
    public function show(Liste $liste)
    {
        $liste->load('thes.type', 'thes.provenance', 'thes.variete');
        return view('listes.show', compact('liste'));
    }

    /**
     * Affiche le formulaire d'édition d'une liste
     */
    public function edit(Liste $liste)
    {
        return view('listes.edit', compact('liste'));
    }

    /**
     * Met à jour une liste
     */
    public function update(Request $request, Liste $liste)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $liste->update([
            'nom' => $validated['nom'],
        ]);

        return redirect()->route('listes.index')
            ->with('success', 'Liste mise à jour avec succès');
    }

    /**
     * Supprime une liste
     */
    public function destroy(Liste $liste)
    {
        $liste->thes()->detach();
        $liste->delete();

        return redirect()->route('listes.index')
            ->with('success', 'Liste supprimée avec succès');
    }

    /**
     * Exporte une liste en PDF
     */
    public function export(Liste $liste)
    {
        $liste->load('thes.type', 'thes.provenance', 'thes.variete');
        
        $pdf = PDF::loadView('listes.pdf', compact('liste'));
        
        return $pdf->download($liste->nom . '.pdf');
    }

    /**
     * Ajoute un thé à une liste
     */
    public function addThe(Liste $liste, The $the)
    {
        if (!$liste->thes()->where('id_the', $the->id_the)->exists()) {
            $liste->thes()->attach($the->id_the);
            return response()->json(['message' => 'Thé ajouté à la liste avec succès']);
        }
        
        return response()->json(['message' => 'Ce thé est déjà dans la liste'], 400);
    }

    /**
     * Retire un thé d'une liste
     */
    public function removeThe(Liste $liste, The $the)
    {
        $liste->thes()->detach($the->id_the);
        return response()->json(['message' => 'Thé retiré de la liste avec succès']);
    }
}