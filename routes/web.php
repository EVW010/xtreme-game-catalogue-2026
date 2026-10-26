<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;


// Openbare pagina's
// Iedereen mag deze bekijken

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/contact', function () {
    return view('contact');
});


// Game Catalogue bekijken
// Iedereen mag games bekijken en zoeken

Route::get('/games', [GameController::class, 'index'])
    ->name('games.index');


// Alleen ingelogde gebruikers

Route::middleware('auth')->group(function () {

    // Game toevoegen
    Route::get('/games/create', [GameController::class, 'create'])
        ->name('games.create');

    // Game opslaan
    Route::post('/games', [GameController::class, 'store'])
        ->name('games.store');

    // Game bewerken
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])
        ->name('games.edit');

    // Game aanpassen
    Route::put('/games/{game}', [GameController::class, 'update'])
        ->name('games.update');

    // Game verwijderen
    Route::delete('/games/{game}', [GameController::class, 'destroy'])
        ->name('games.destroy');


    // Game activeren of deactiveren
    // Admincontrole staat in de controller

    Route::post('/games/{game}/toggle-active', [
        GameController::class,
        'toggleActive'
    ])->name('games.toggle-active');


    // Admin pagina
    // Alleen role 1 mag deze pagina bekijken

    Route::get('/admin', function () {

        abort_unless(
            auth()->user()->role === 1,
            403
        );

        return view('admin.dashboard');

    })->name('admin.dashboard');


    // Dashboard

    Route::get('/dashboard', function () {
        return view('dashboard');
    })
        ->middleware('verified')
        ->name('dashboard');


    // Profiel

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


// Inloggen en registreren

require __DIR__ . '/auth.php';
