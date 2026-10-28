<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Game en reviews bekijken
    public function show(Game $game)
    {
        // Alleen actieve games zijn openbaar
        $isAdmin = auth()->check()
            && auth()->user()->role === 1;

        $isOwner = auth()->check()
            && $game->user_id === auth()->id();

        abort_unless(
            $game->is_active || $isAdmin || $isOwner,
            404
        );

        // Gamegegevens ophalen
        $game->load(['genre', 'platforms']);

        // Reviews ophalen
        $reviews = $game->reviews()
            ->with('user')
            ->latest()
            ->get();

        $completedGames = 0;
        $alreadyReviewed = false;

        if (auth()->check()) {

            // Tellen hoeveel games uitgespeeld zijn
            $completedGames = auth()->user()
                ->games()
                ->wherePivot('status', 'completed')
                ->count();

            // Controleren of gebruiker al een review heeft
            $alreadyReviewed = auth()->user()
                ->reviews()
                ->where('game_id', $game->id)
                ->exists();
        }

        return view('games.show', [
            'game' => $game,
            'reviews' => $reviews,
            'completedGames' => $completedGames,
            'alreadyReviewed' => $alreadyReviewed,
        ]);
    }

    // Review opslaan
    public function store(Request $request, Game $game)
    {
        // Alleen bij actieve games
        abort_unless($game->is_active, 404);

        // Formulier controleren
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        // Aantal uitgespeelde games tellen
        $completedGames = auth()->user()
            ->games()
            ->wherePivot('status', 'completed')
            ->count();

        // Minimaal 3 uitgespeelde games nodig
        if ($completedGames < 3) {

            return back()->withErrors([
                'review' => 'Je moet eerst minimaal 3 games uitspelen.',
            ]);
        }

        // Controleren op dubbele review
        $alreadyReviewed = auth()->user()
            ->reviews()
            ->where('game_id', $game->id)
            ->exists();

        if ($alreadyReviewed) {

            return back()->withErrors([
                'review' => 'Je hebt deze game al beoordeeld.',
            ]);
        }

        // Review toevoegen
        $game->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('games.show', $game)
            ->with('success', 'Review toegevoegd!');
    }
}
