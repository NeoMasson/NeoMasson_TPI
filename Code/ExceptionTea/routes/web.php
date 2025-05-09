<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\TheController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('listes', ListeController::class);
    Route::resource('thes', TheController::class);
    Route::get('/thes/{the}', [TheController::class, 'show'])->name('thes.show');
    Route::post('/listes/{liste}/export', [ListeController::class, 'export'])->name('listes.export');
    Route::get('/thes/{the}/edit', [TheController::class, 'edit'])->name('thes.edit');
    Route::put('/thes/{the}', [TheController::class, 'update'])->name('thes.update');
    Route::delete('/thes/{the}', [TheController::class, 'destroy'])->name('thes.destroy');
    
    // Routes pour gérer les thés dans les listes
    Route::post('/listes/{liste}/thes/{the}', [ListeController::class, 'addThe'])->name('listes.add-the');
    Route::delete('/listes/{liste}/thes/{the}', [ListeController::class, 'removeThe'])->name('listes.remove-the');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les thés
    Route::get('/thes', [TheController::class, 'index'])->name('thes.index');
    Route::get('/thes/create', [TheController::class, 'create'])->name('thes.create');
    Route::post('/thes', [TheController::class, 'store'])->name('thes.store');
    Route::get('/thes/{the}', [TheController::class, 'show'])->name('thes.show');
    Route::get('/thes/{the}/edit', [TheController::class, 'edit'])->name('thes.edit');
    Route::put('/thes/{the}', [TheController::class, 'update'])->name('thes.update');
    Route::delete('/thes/{the}', [TheController::class, 'destroy'])->name('thes.destroy');
});

require __DIR__.'/auth.php';
