<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;


// Games bekijken - openbaar
Route::get('/games', [GameController::class, 'index'])
    ->name('games.index');


// Game acties - alleen ingelogde gebruikers
Route::middleware('auth')->group(function () {

    // Game toevoegen formulier
    Route::get('/games/create', [GameController::class, 'create'])
        ->name('games.create');

    // Nieuwe game opslaan
    Route::post('/games', [GameController::class, 'store'])
        ->name('games.store');

    // Game bewerken formulier
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])
        ->name('games.edit');

    // Game aanpassen
    Route::put('/games/{game}', [GameController::class, 'update'])
        ->name('games.update');

    Route::delete('/games/{game}', [GameController::class, 'destroy'])
        ->name('games.destroy');

});


// Homepagina
Route::get('/home', [HomeController::class, 'index'])
    ->name('home');


// Contactpagina
Route::get('/contact', function () {
    return view('contact');
});


// Welkomstpagina
Route::get('/', function () {
    return view('welcome');
});


// Dashboard - alleen ingelogd + verified
Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Profiel - alleen ingelogde gebruikers
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


require __DIR__ . '/auth.php';
