<?php

namespace App\Http\Controllers;

use App\Models\The;
use App\Models\Type;
use App\Models\Provenance;
use Illuminate\Http\Request;

/**
 * Contrôleur responsable de la page d'accueil (dashboard)
 * Gère l'affichage du catalogue complet des thés avec leurs filtres
 */
class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord principal de l'application
     * Charge les thés avec leurs relations et les données nécessaires aux filtres
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère tous les thés avec leurs relations pour éviter les requêtes N+1
        $thes = The::with(['type', 'provenance', 'variete'])->get();
        
        // Charge les données pour les filtres de type et de provenance
        $types = Type::all();
        $provenances = Provenance::all();

        return view('dashboard', compact('thes', 'types', 'provenances'));
    }
}