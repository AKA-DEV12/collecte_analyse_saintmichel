<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RendezVousController as AdminRdv;
use App\Http\Controllers\Admin\ScheduleController as AdminSchedule;
use App\Http\Controllers\Admin\AumonierController as AdminAumonier;
use App\Http\Controllers\Client\RendezVousController as ClientRdv;

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('rendezvous')->name('rendezvous.')->group(function () {
        Route::get('pending', [AdminRdv::class, 'indexPending'])->name('pending');
        Route::get('done', [AdminRdv::class, 'indexDone'])->name('done');
        Route::get('settings', [AdminRdv::class, 'settings'])->name('settings');
        Route::get('calendar/create', [AdminSchedule::class, 'create'])->name('calendar.create');
        Route::post('calendar', [AdminSchedule::class, 'store'])->name('calendar.store');

        Route::resource('aumoniers', AdminAumonier::class)->only(['index','create','store','edit','update']);
    });
});

// Client routes
Route::prefix('rdv')->name('rdv.')->group(function () {
    Route::get('/', [ClientRdv::class, 'listAumoniers'])->name('list');
    Route::get('/select/{aumonier}', [ClientRdv::class, 'select'])->name('select');
    Route::get('/dates/{aumonier}', [ClientRdv::class, 'availableDates'])->name('dates');
    Route::get('/slots/{dateId}', [ClientRdv::class, 'availableSlots'])->name('slots');
    Route::post('/book', [ClientRdv::class, 'book'])->name('book');
});
