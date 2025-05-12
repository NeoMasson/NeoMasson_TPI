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
    Route::post('/api/varietes', [VarieteController::class, 'store'])->name('api.varietes.store');
    Route::put('/api/varietes/{id}', [VarieteController::class, 'update'])->name('api.varietes.update');
    Route::delete('/api/varietes/{id}', [VarieteController::class, 'destroy'])->name('api.varietes.destroy');

    // Routes API pour la gestion des provenances (CRUD ajax)
    Route::post('/api/provenances', [ProvenanceController::class, 'store'])->name('api.provenances.store');
    Route::put('/api/provenances/{id}', [ProvenanceController::class, 'update'])->name('api.provenances.update');
    Route::delete('/api/provenances/{id}', [ProvenanceController::class, 'destroy'])->name('api.provenances.destroy');

    // Routes API pour la gestion des types (CRUD ajax)
    Route::post('/api/types', [TypeController::class, 'store'])->name('api.types.store');
    Route::put('/api/types/{id}', [TypeController::class, 'update'])->name('api.types.update');
    Route::delete('/api/types/{id}', [TypeController::class, 'destroy'])->name('api.types.destroy');

    // Routes pour les thés (CRUD complet)
    Route::resource('thes', TheController::class);
});

// Groupe de routes nécessitant uniquement une authentification
Route::middleware('auth')->group(function () {
    // Routes pour la gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
