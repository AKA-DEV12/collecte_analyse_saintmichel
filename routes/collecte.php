<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollecteController;
use App\Http\Controllers\EnregistrementController;

Route::middleware(['auth', 'verified'])->prefix('collecte')->group(function () {
    Route::get('/', [CollecteController::class, 'index'])->name('collecte.index');
    Route::get('/creation', [CollecteController::class, 'create'])->name('collecte.create');
    Route::post('/store', [CollecteController::class, 'store'])->name('collecte.store');
    Route::get('/modification-de-champs/{id}', [CollecteController::class, 'edit'])->name('collecte.edit');
    Route::patch('/mise-a-jour/{id}', [CollecteController::class, 'update'])->name('collecte.update');
    Route::delete('/suppression/{id}', [CollecteController::class, 'delete'])->name('collecte.delete');


    Route::get('/enregistrement/{id}/show', [CollecteController::class, 'show'])->name('collecte.show');
    Route::get('/enregistrement/{id}', [CollecteController::class, 'formulaire'])->name('collecte.formulaire');

    Route::post('/enregistremen/store', [EnregistrementController::class, 'store'])->name('collecte.enregistrement.store');
});
