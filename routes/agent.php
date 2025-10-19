<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;

use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'verified'])->prefix('agents')->group(function () {


  


    Route::post('/', [AgentController::class, 'index'])->name('agent.index');


    Route::post('/store', [AgentController::class, 'store'])->name('agent.store');

    Route::get('/modification-de-champs-agent/{id}', [AgentController::class, 'edit'])->name('agent.edit');

    Route::patch('/mise-a-jour/{id}', [AgentController::class, 'update'])->name('agent.update');

    Route::delete('/suppression{id}', [AgentController::class, 'delete'])->name('agent.delete');


    Route::get('/tableau-de-bord', [AgentController::class, 'dashboard'])->name('agent.dashboard');

    Route::get('/recensement', [AgentController::class, 'recensement'])->name('agent.recensement.index');
    Route::get('/recensement/formulaire', [AgentController::class, 'formulaire'])->name('agent.recensement.formulaire');
        Route::get('/projet', [AgentController::class, 'projet'])->name('agent.projet.index');

});
