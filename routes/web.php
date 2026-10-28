<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


// Openbare pagina's
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/contact', function () {
    return view('contact');
});


// Gamecatalogus
Route::get('/games', [GameController::class, 'index'])
    ->name('games.index');


// Alleen ingelogde gebruikers
Route::middleware('auth')->group(function () {

    // Mijn collectie
    Route::get('/mijn-collectie', [CollectionController::class, 'index'])
        ->name('collection.index');

    Route::post('/mijn-collectie/{game}', [CollectionController::class, 'store'])
        ->name('collection.store');

    Route::patch('/mijn-collectie/{game}/status', [CollectionController::class, 'updateStatus'])
        ->name('collection.update-status');

    Route::delete('/mijn-collectie/{game}', [CollectionController::class, 'destroy'])
        ->name('collection.destroy');


    // Game toevoegen
    Route::get('/games/create', [GameController::class, 'create'])
        ->name('games.create');

    Route::post('/games', [GameController::class, 'store'])
        ->name('games.store');


    // Game bewerken
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])
        ->name('games.edit');

    Route::put('/games/{game}', [GameController::class, 'update'])
        ->name('games.update');


    // Game verwijderen
    Route::delete('/games/{game}', [GameController::class, 'destroy'])
        ->name('games.destroy');


    // Actief / inactief
    Route::post('/games/{game}/toggle-active', [GameController::class, 'toggleActive'])
        ->name('games.toggle-active');


    // Review plaatsen
    Route::post('/games/{game}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');


    // Adminpagina
    Route::get('/admin', function () {

        abort_unless(auth()->user()->role === 1, 403);

        return view('admin.dashboard');

    })->name('admin.dashboard');


    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })
        ->middleware('verified')
        ->name('dashboard');


    // Profiel
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// Game detailpagina is openbaar
Route::get('/games/{game}', [ReviewController::class, 'show'])
    ->name('games.show');


// Inloggen en registreren
require __DIR__ . '/auth.php';
