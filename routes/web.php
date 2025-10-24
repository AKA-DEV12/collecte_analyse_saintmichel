<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;
use App\Models\Recensement;
use Carbon\Carbon;

Route::get('/', function () {
    return view('auth.login');
});

// Health endpoint for platform checks
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// Handle CORS preflight (avoid 405 for OPTIONS behind proxy)
Route::options('/{any}', function () {
    return response('', 204);
})->where('any', '.*');


Route::get('/dashboard', function (Request $request) {
        // Vérifie le rôle de l'utilisateur
        if (!Auth::check() || Auth::user()->role != 1) {
            abort(403, 'Accès interdit.');
        }

        // Crée une instance du contrôleur et appelle la méthode
        return app(DashboardController::class)->index($request);
    })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/collecte.php';
require __DIR__ . '/recensement.php';
require __DIR__ . '/agent.php';
require __DIR__ . '/rendezvous.php';
