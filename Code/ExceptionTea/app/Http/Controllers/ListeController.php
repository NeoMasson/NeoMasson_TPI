<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use App\Models\The;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Contrôleur pour la gestion des listes de thés
 * 
 * Ce contrôleur gère l'ensemble des opérations CRUD pour les listes de thés,
 * ainsi que les fonctionnalités avancées comme :
 * - L'export des listes en PDF
 * - La gestion des relations many-to-many avec les thés
 * - Le tri et l'organisation des listes
 * 
 * Les listes permettent aux utilisateurs de créer des collections personnalisées
 * de thés pour différents usages (favoris, à acheter, etc.).
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
     * 
     * Cette méthode gère :
     * - La mise à jour du nom de la liste
     * - La synchronisation des thés associés (ajout/suppression)
     * - La validation des données entrées
     * 
     * @param Request $request Les données du formulaire de mise à jour
     * @param Liste $liste La liste à mettre à jour
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Validation\ValidationException Si les données sont invalides
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
     * Supprime une liste et ses associations
     * 
     * Cette méthode :
     * - Détache tous les thés associés (relation many-to-many)
     * - Supprime l'enregistrement de la liste
     * - Redirige avec un message de succès
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
     * Génère un PDF de la liste de thés
     * 
     * Cette méthode crée un document PDF contenant :
     * - Les informations de base de la liste (nom, date)
     * - La liste détaillée des thés avec leurs caractéristiques
     * - Un en-tête et pied de page personnalisés
     * 
     * @param Liste $liste La liste à exporter en PDF
     * @return \Illuminate\Http\Response Le fichier PDF à télécharger
     */
    public function generatePDF(Liste $liste)
    {
        $liste->load('thes.type', 'thes.provenance', 'thes.variete');
        
        $pdf = PDF::loadView('listes.pdf', compact('liste'));
        
        return $pdf->download($liste->nom . '.pdf');
    }

    /**
     * Ajoute ou retire un thé d'une liste
     * 
     * Cette méthode gère de manière asynchrone :
     * - L'ajout d'un thé à la liste si non présent
     * - Le retrait d'un thé de la liste si déjà présent
     * - La validation des données et des permissions
     * 
     * @param Request $request Contient l'ID du thé à ajouter/retirer
     * @param Liste $liste La liste à modifier
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Validation\ValidationException Si l'ID du thé est invalide
     */
    public function toggleThe(Request $request, Liste $liste)
    {
        $validated = $request->validate([
            'the_id' => 'required|exists:t_the,id_the',
        ]);

        $theId = $validated['the_id'];

        if ($liste->thes()->where('id_the', $theId)->exists()) {
            $liste->thes()->detach($theId);
            $message = 'Thé retiré de la liste avec succès';
        } else {
            $liste->thes()->attach($theId);
            $message = 'Thé ajouté à la liste avec succès';
        }

        return response()->json(['message' => $message]);
    }
}