<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecensementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Routes Web – Recensements
|--------------------------------------------------------------------------
|
| CRUD complet et complexe pour le modèle Recensement.
|
*/

Route::middleware(['auth'])->group(function () {

    Route::prefix('recensements')->name('recensement.')->group(function () {


     Route::get('/', function (Request $request) {
        // Vérifie le rôle de l'utilisateur
        if (!Auth::check() || Auth::user()->role != 1) {
            abort(403, 'Accès interdit.');
        }

        // Crée une instance du contrôleur et appelle la méthode
        return app(RecensementController::class)->index($request);
    })->name('index');
        // ➤ Liste complète avec pagination, tri, filtre

        Route::get('/formulaire', [RecensementController::class, 'formulaire'])->name('formulaire');

        // Formulaire de création
        Route::get('/create', [RecensementController::class, 'create'])->name('create');

        // Enregistrement d’un nouveau recensement
        Route::post('/', [RecensementController::class, 'store'])->name('store');

        // Afficher les détails d’un recensement
        Route::get('/{id}', [RecensementController::class, 'show'])->name('show');

        // Formulaire d’édition
        Route::get('/{id}/edit', [RecensementController::class, 'edit'])->name('edit');

        // Mise à jour d’un recensement 
        Route::patch('/{id}', [RecensementController::class, 'update'])->name('update');

        // Suppression d’un recensement
        Route::delete('/{id}', [RecensementController::class, 'destroy'])->name('destroy');

        // Recherche avancée (par nom, quartier, etc.)
        Route::get('/search', [RecensementController::class, 'search'])->name('search');

        // Exportation (PDF, Excel, CSV)
        Route::get('/export/{format}', [RecensementController::class, 'export'])->name('export');

        // Filtrage dynamique (ex : baptisés, mariés, etc.)
        Route::get('/filter/{type}', [RecensementController::class, 'filter'])->name('filter');

        // Duplication rapide d’un enregistrement existant
        Route::post('/{id}/duplicate', [RecensementController::class, 'duplicate'])->name('duplicate');

        // Suppression multiple
        Route::delete('/bulk/delete', [RecensementController::class, 'bulkDelete'])->name('bulk.delete');
    });
});
