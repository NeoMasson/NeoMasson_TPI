<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\TheController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VarieteController;
use App\Http\Controllers\ProvenanceController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

// Route d'accueil - Page principale de l'application
Route::get('/', function () {
    return view('welcome');
});

// Groupe de routes nécessitant une authentification et une vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - Tableau de bord principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les listes (resource inclut index, create, store, show, edit, update, destroy)
    Route::resource('listes', ListeController::class);

    // Route d'export PDF pour une liste spécifique
    Route::post('/listes/{liste}/export', [ListeController::class, 'export'])->name('listes.export');
    
    // Routes pour la gestion des thés dans les listes
    Route::post('/listes/{liste}/thes/{the}', [ListeController::class, 'addThe'])->name('listes.add-the');
    Route::delete('/listes/{liste}/thes/{the}', [ListeController::class, 'removeThe'])->name('listes.remove-the');

    // Routes API pour la gestion des variétés (CRUD ajax)
    // Crée une nouvelle variété de thé
    Route::post('/api/varietes', [VarieteController::class, 'store'])->name('api.varietes.store');
    // Met à jour une variété existante
    Route::put('/api/varietes/{id}', [VarieteController::class, 'update'])->name('api.varietes.update');
    // Supprime une variété spécifique
    Route::delete('/api/varietes/{id}', [VarieteController::class, 'destroy'])->name('api.varietes.destroy');
    // Récupère la liste de toutes les variétés
    Route::get('/api/varietes/list', [VarieteController::class, 'list'])->name('api.varietes.list');

    // Routes API pour la gestion des provenances (CRUD ajax)
    // Crée une nouvelle provenance de thé
    Route::post('/api/provenances', [ProvenanceController::class, 'store'])->name('api.provenances.store');
    // Met à jour une provenance existante
    Route::put('/api/provenances/{id}', [ProvenanceController::class, 'update'])->name('api.provenances.update');
    // Supprime une provenance spécifique
    Route::delete('/api/provenances/{id}', [ProvenanceController::class, 'destroy'])->name('api.provenances.destroy');
    // Récupère la liste de toutes les provenances
    Route::get('/api/provenances/list', [ProvenanceController::class, 'list'])->name('api.provenances.list');

    // Routes API pour la gestion des types (CRUD ajax)
    // Crée un nouveau type de thé
    Route::post('/api/types', [TypeController::class, 'store'])->name('api.types.store');
    // Met à jour un type existant
    Route::put('/api/types/{id}', [TypeController::class, 'update'])->name('api.types.update');
    // Supprime un type spécifique
    Route::delete('/api/types/{id}', [TypeController::class, 'destroy'])->name('api.types.destroy');
    // Récupère la liste de tous les types
    Route::get('/api/types/list', [TypeController::class, 'list'])->name('api.types.list');

    // Routes pour les thés (CRUD complet)
    Route::resource('thes', TheController::class);
});

// Groupe de routes nécessitant uniquement une authentification (Par défaut)
Route::middleware('auth')->group(function () {
    // Routes pour la gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
