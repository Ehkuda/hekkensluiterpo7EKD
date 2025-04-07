<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GedetineerdeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('gedetineerden', [GedetineerdeController::class, 'index'])->name('gedetineerden');
Route::get('gedetineerden/overplaatsen/{id}', [GedetineerdeController::class, 'overplaatsen'])->name('overplaatsen');
Route::get('gedetineerden/wijzigen/{id}', [GedetineerdeController::class, 'wijzigen'])->name('wijzigen');
Route::get('gedetineerden/verwijderen/{id}', [GedetineerdeController::class, 'verwijderen'])->name('verwijderen');


require __DIR__.'/auth.php';

