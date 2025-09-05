<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GedetineerdenController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VisitRequestController;
use Illuminate\Support\Facades\Route;

// Welkomstpagina
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Publieke route voor bezoekverzoeken (GEEN authenticatie vereist)
Route::get('/bezoekverzoek', [VisitRequestController::class, 'create'])->name('visit-requests.create');
Route::post('/bezoekverzoek', [VisitRequestController::class, 'store'])->name('visit-requests.store');

// Auth routes
require __DIR__ . '/auth.php';

// Routes voor ingelogde en geverifieerde gebruikers
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [GedetineerdenController::class, 'dashboard'])
        ->name('dashboard');

    // Bezoekverzoeken beheer (alleen voor staff)
    Route::prefix('visit-requests')->name('visit-requests.')->group(function () {
        Route::get('/', [VisitRequestController::class, 'index'])->name('index')->middleware('can:visit-requests.view');
        
        // SPECIFIEKE routes eerst!
        Route::get('/{visitRequest}/approval', [VisitRequestController::class, 'showApprovalForm'])->name('approval')->middleware('can:visit-requests.approve');
        Route::put('/{visitRequest}/approve', [VisitRequestController::class, 'approve'])->name('approve')->middleware('can:visit-requests.approve');
        Route::put('/{visitRequest}/reject', [VisitRequestController::class, 'reject'])->name('reject')->middleware('can:visit-requests.approve');
        
        // ALGEMENE route als laatste!
        Route::get('/{visitRequest}', [VisitRequestController::class, 'show'])->name('show')->middleware('can:visit-requests.view');
    });

    // Bezoekersbeheer
    Route::prefix('visitors')->name('visitors.')->group(function () {
        Route::get('/', [VisitorController::class, 'index'])->name('index')->middleware('can:visitors.view');
        Route::get('/create', [VisitorController::class, 'create'])->name('create')->middleware('can:visitors.create');
        Route::post('/', [VisitorController::class, 'store'])->name('store')->middleware('can:visitors.create');
        Route::get('/{visitor}', [VisitorController::class, 'show'])->name('show')->middleware('can:visitors.view');
        Route::put('/{visit}/departure', [VisitorController::class, 'updateDeparture'])->name('departure.update')->middleware('can:visits.update');
    });

    // Gedetineerdenbeheer
    Route::prefix('gedetineerden')->name('gedetineerden.')->group(function () {
        Route::get('/', [GedetineerdenController::class, 'index'])->name('index')->middleware('can:gedetineerden.view');
        Route::get('/create', [GedetineerdenController::class, 'create'])->name('create')->middleware('can:gedetineerden.create');
        Route::post('/', [GedetineerdenController::class, 'store'])->name('store')->middleware('can:gedetineerden.create');
        Route::get('/{gedetineerde}', [GedetineerdenController::class, 'show'])->name('show')->middleware('can:gedetineerden.view');
        Route::get('/{gedetineerde}/edit', [GedetineerdenController::class, 'edit'])->name('edit')->middleware('can:gedetineerden.edit');
        Route::put('/{gedetineerde}', [GedetineerdenController::class, 'update'])->name('update')->middleware('can:gedetineerden.edit');
        Route::delete('/{gedetineerde}', [GedetineerdenController::class, 'destroy'])->name('destroy')->middleware('can:gedetineerden.delete');
        Route::get('/{gedetineerde}/geschiedenis', [GedetineerdenController::class, 'geschiedenis'])->name('geschiedenis')->middleware('can:gedetineerden.history');
    });

    // Cellenbeheer
    Route::prefix('cellen')->name('cellen.')->group(function () {
        Route::get('/', [GedetineerdenController::class, 'cellenIndex'])->name('index')->middleware('can:cellen.view');
        Route::get('/{cel}/geschiedenis', [GedetineerdenController::class, 'celGeschiedenis'])->name('geschiedenis')->middleware('can:cellen.history');
        Route::get('/{cel}/verplaats', [GedetineerdenController::class, 'showVerplaatsForm'])->name('verplaats')->middleware('can:cellen.move');
        Route::post('/{cel}/verplaats', [GedetineerdenController::class, 'verplaatsGedetineerde'])->name('gedetineerden.verplaats.store')->middleware('can:cellen.move');
    });

    // Admin module
    Route::prefix('admin')->name('admin.')->middleware('can:admin.dashboard')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'users'])->name('index')->middleware('can:users.view');
            Route::get('/create', [AdminController::class, 'createUser'])->name('create')->middleware('can:users.create');
            Route::post('/', [AdminController::class, 'storeUser'])->name('store')->middleware('can:users.create');
            Route::get('/{user}/edit', [AdminController::class, 'editUser'])->name('edit')->middleware('can:users.edit');
            Route::put('/{user}', [AdminController::class, 'updateUser'])->name('update')->middleware('can:users.edit');
            Route::delete('/{user}', [AdminController::class, 'deleteUser'])->name('destroy')->middleware('can:users.delete');
        });

        // Roles
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [AdminController::class, 'roles'])->name('index')->middleware('can:roles.view');
            Route::get('/create', [AdminController::class, 'createRole'])->name('create')->middleware('can:roles.create');
            Route::post('/', [AdminController::class, 'storeRole'])->name('store')->middleware('can:roles.create');
            Route::get('/{role}/edit', [AdminController::class, 'editRole'])->name('edit')->middleware('can:roles.edit');
            Route::put('/{role}', [AdminController::class, 'updateRole'])->name('update')->middleware('can:roles.edit');
            Route::delete('/{role}', [AdminController::class, 'deleteRole'])->name('destroy')->middleware('can:roles.delete');
        });

        // Gedetineerden overzicht (admin)
        Route::get('/gedetineerden', [AdminController::class, 'gedetineerdenOverzicht'])->name('gedetineerden.index')->middleware('can:gedetineerden.view');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index')->middleware('can:admin.settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update')->middleware('can:admin.settings');
    });

    // Profielbeheer
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
