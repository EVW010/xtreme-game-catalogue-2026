<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ReviewController;
use App\Models\Game;
use Illuminate\Support\Facades\Route;

// Openbare pagina's
Route::redirect('/', '/games');
Route::redirect('/home', '/games')->name('home');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/games', [GameController::class, 'index'])->name('games.index');

// Alleen ingelogde gebruikers
Route::middleware('auth')->group(function () {

    // Persoonlijke collectie
    Route::get('/mijn-collectie', [CollectionController::class, 'index'])->name('collection.index');
    Route::post('/mijn-collectie/{game}', [CollectionController::class, 'store'])->name('collection.store');
    Route::patch('/mijn-collectie/{game}/status', [CollectionController::class, 'updateStatus'])->name('collection.update-status');
    Route::delete('/mijn-collectie/{game}', [CollectionController::class, 'destroy'])->name('collection.destroy');

    // Games toevoegen, bewerken en verwijderen
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

    // Games activeren of deactiveren
    Route::post('/games/{game}/toggle-active', [GameController::class, 'toggleActive'])->name('games.toggle-active');

    // Reviews
    Route::post('/games/{game}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Admin dashboard
    Route::get('/admin', function () {
        abort_unless(auth()->user()->role === 1, 403);

        $games = Game::orderBy('title')->get();

        return view('admin.dashboard', compact('games'));
    })->name('admin.dashboard');

    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('games.index');
    })->middleware('verified')->name('dashboard');

    // Profiel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Game-details zijn openbaar
Route::get('/games/{game}', [ReviewController::class, 'show'])->name('games.show');

require __DIR__ . '/auth.php';
