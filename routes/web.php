<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GedetineerdenController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

// Welkomstpagina
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
require __DIR__ . '/auth.php';

// Routes voor ingelogde en geverifieerde gebruikers
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [GedetineerdenController::class, 'dashboard'])->name('dashboard');

    // Bezoekersbeheer
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::get('/visitors/create', [VisitorController::class, 'create'])->name('visitors.create');
    Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    Route::get('/visitors/{visitor}', [VisitorController::class, 'show'])->name('visitors.show');
    Route::put('/visits/{visit}/departure', [VisitorController::class, 'updateDeparture'])->name('visits.departure.update');

    // Gedetineerdenbeheer - alleen coordinator of directeur
    Route::middleware(['role:coordinator|directeur'])->group(function () {
        Route::get('/gedetineerden/create', [GedetineerdenController::class, 'create'])->name('gedetineerden.create');
        Route::post('/gedetineerden', [GedetineerdenController::class, 'store'])->name('gedetineerden.store');
        Route::get('/gedetineerden/{gedetineerde}/edit', [GedetineerdenController::class, 'edit'])->name('gedetineerden.edit');
        Route::put('/gedetineerden/{gedetineerde}', [GedetineerdenController::class, 'update'])->name('gedetineerden.update');
        Route::delete('/gedetineerden/{gedetineerde}', [GedetineerdenController::class, 'destroy'])->name('gedetineerden.destroy');

        Route::get('/cellen/{cel}/verplaats', [GedetineerdenController::class, 'showVerplaatsForm'])->name('cellen.verplaats');
        Route::post('/cellen/{cel}/verplaats', [GedetineerdenController::class, 'verplaatsGedetineerde'])->name('cellen.gedetineerden.verplaats.store');
    });

    // Gedetineerden overzicht en details (alle ingelogde gebruikers)
    Route::get('/gedetineerden', [GedetineerdenController::class, 'index'])->name('gedetineerden.index');
    Route::get('/gedetineerden/{gedetineerde}', [GedetineerdenController::class, 'show'])->name('gedetineerden.show');
    Route::get('/cellen', [GedetineerdenController::class, 'cellenIndex'])->name('cellen.index');

    // Alleen directeur
    Route::middleware(['role:directeur'])->group(function () {
        Route::get('/gedetineerden/{gedetineerde}/geschiedenis', [GedetineerdenController::class, 'geschiedenis'])->name('gedetineerden.geschiedenis');
        Route::get('/cellen/{cel}/geschiedenis', [GedetineerdenController::class, 'celGeschiedenis'])->name('cellen.geschiedenis');

        // Admin module
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/users', [AdminController::class, 'users'])->name('users.index');
            Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
            Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
            Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
            Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
            Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');

            Route::get('/roles', [AdminController::class, 'roles'])->name('roles.index');
            Route::get('/roles/create', [AdminController::class, 'createRole'])->name('roles.create');
            Route::post('/roles', [AdminController::class, 'storeRole'])->name('roles.store');
            Route::get('/roles/{role}/edit', [AdminController::class, 'editRole'])->name('roles.edit');
            Route::put('/roles/{role}', [AdminController::class, 'updateRole'])->name('roles.update');
            Route::delete('/roles/{role}', [AdminController::class, 'deleteRole'])->name('roles.destroy');

            Route::get('/gedetineerden', [AdminController::class, 'gedetineerdenOverzicht'])->name('gedetineerden.index');
            Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
            Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        });
    });

    // Profielbeheer (alle ingelogde gebruikers)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
