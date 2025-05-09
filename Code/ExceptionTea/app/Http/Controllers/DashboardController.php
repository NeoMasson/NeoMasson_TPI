<?php

namespace App\Http\Controllers;

use App\Models\The;
use App\Models\Type;
use App\Models\Provenance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec la liste des thés
     */
    public function index()
    {
        $thes = The::with(['type', 'provenance', 'variete'])->get();
        $types = Type::all();
        $provenances = Provenance::all();

        return view('dashboard', compact('thes', 'types', 'provenances'));
    }
}