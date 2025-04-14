<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GedetineerdenController;
use App\Http\Controllers\CelController;

Route::resource('gedetineerden', GedetineerdenController::class); // Dit genereert alle benodigde CRUD-routes voor Gedetineerden

// Extra routes voor cellen en verplaatsingen
Route::get('/cellen', [GedetineerdenController::class, 'cellenIndex'])->name('cellen.index');
Route::get('cellen/{cel}/verplaats', [GedetineerdenController::class, 'showVerplaatsForm'])->name('cellen.verplaats');
Route::post('cellen/{cel}/verplaats', [GedetineerdenController::class, 'verplaatsGedetineerde']);
Route::get('/cellen/{cel}/geschiedenis', [GedetineerdenController::class, 'geschiedenis'])->name('cellen.geschiedenis');
Route::get('/cellen/{cel}/geschiedenis', [GedetineerdenController::class, 'celGeschiedenis'])->name('cellen.geschiedenis');

// Updated dashboard route
Route::get('/dashboard', [GedetineerdenController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes voor het dashboard en profiel
Route::get('/', function () {
    return view('welcome');
});

// Auth routes voor profielbeheer
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes voor login
require __DIR__.'/auth.php';