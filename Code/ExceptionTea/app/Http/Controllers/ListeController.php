<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\The;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Contrôleur gérant les opérations CRUD sur les listes de thés
 * et les interactions entre les listes et les thés
 */
class ListeController extends Controller
{
    /**
     * Affiche la page d'index des listes de thés
     * Les listes sont triées par date de création (plus récentes en premier)
     * et incluent le nombre de thés qu'elles contiennent
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $listes = Liste::withCount('thes')->orderBy('date_creation', 'desc')->get();
        return view('listes.index', compact('listes'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle liste
     * Charge tous les thés disponibles avec leurs relations pour le sélecteur
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $thes = The::with(['type', 'provenance', 'variete'])->get();
        return view('listes.create', compact('thes'));
    }

    /**
     * Enregistre une nouvelle liste dans la base de données
     * Gère également l'attachement des thés sélectionnés à la liste
     *
     * @param Request $request Les données du formulaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'thes' => 'array',
            'thes.*' => 'exists:t_the,id_the'
        ]);

        $liste = Liste::create([
            'nom' => $validated['nom'],
            'date_creation' => now(),
        ]);

        if (!empty($validated['thes'])) {
            $liste->thes()->attach($validated['thes']);
        }

        return redirect()->route('listes.index')
            ->with('success', 'Liste créée avec succès');
    }

    /**
     * Affiche les détails d'une liste spécifique
     * Charge les thés associés avec toutes leurs relations pour l'affichage
     *
     * @param Liste $liste La liste à afficher (injection de modèle)
     * @return \Illuminate\View\View
     */
    public function show(Liste $liste)
    {
        $liste->load('thes.type', 'thes.provenance', 'thes.variete');
        return view('listes.show', compact('liste'));
    }

    /**
     * Affiche le formulaire d'édition d'une liste
     * Charge tous les thés disponibles pour permettre leur sélection
     *
     * @param Liste $liste La liste à éditer
     * @return \Illuminate\View\View
     */
    public function edit(Liste $liste)
    {
        $liste->load('thes');
        $thes = The::with(['type', 'provenance', 'variete'])->get();
        return view('listes.edit', compact('liste', 'thes'));
    }

    /**
     * Met à jour les informations d'une liste existante
     * Gère également la mise à jour des thés associés
     *
     * @param Request $request Les données du formulaire
     * @param Liste $liste La liste à mettre à jour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Liste $liste)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'thes' => 'array',
            'thes.*' => 'exists:t_the,id_the'
        ]);

        $liste->update([
            'nom' => $validated['nom'],
        ]);

        // Met à jour les thés associés
        $liste->thes()->sync($validated['thes'] ?? []);

        return redirect()->route('listes.index')
            ->with('success', 'Liste mise à jour avec succès');
    }

    /**
     * Supprime une liste et détache tous les thés associés
     *
     * @param Liste $liste La liste à supprimer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Liste $liste)
    {
        $liste->thes()->detach(); // Supprime les associations avec les thés
        $liste->delete();

        return redirect()->route('listes.index')
            ->with('success', 'Liste supprimée avec succès');
    }

    /**
     * Génère et télécharge un PDF contenant les détails de la liste
     * Utilise le package barryvdh/laravel-dompdf pour la génération
     *
     * @param Liste $liste La liste à exporter
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Liste $liste)
    {
        $liste->load('thes.type', 'thes.provenance', 'thes.variete');
        
        $pdf = PDF::loadView('listes.pdf', compact('liste'));
        
        return $pdf->download($liste->nom . '.pdf');
    }

    /**
     * Ajoute un thé à une liste existante via une requête AJAX
     * Vérifie si le thé n'est pas déjà dans la liste avant l'ajout
     *
     * @param Liste $liste La liste à laquelle ajouter le thé
     * @param The $the Le thé à ajouter
     * @return \Illuminate\Http\JsonResponse
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
     * Retire un thé d'une liste via une requête AJAX
     *
     * @param Liste $liste La liste de laquelle retirer le thé
     * @param The $the Le thé à retirer
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeThe(Liste $liste, The $the)
    {
        $liste->thes()->detach($the->id_the);
        return response()->json(['message' => 'Thé retiré de la liste avec succès']);
    }
}