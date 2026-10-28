<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    // Mijn collectie bekijken
    public function index()
    {
        $myGames = auth()->user()->games()
            ->with('genre')
            ->orderBy('games.title')
            ->get();

        // Games die nog niet in mijn collectie staan
        $availableGames = Game::with('genre')
            ->where('is_active', true)
            ->whereDoesntHave('users', function ($query) {
                $query->where('users.id', auth()->id());
            })
            ->orderBy('title')
            ->get();

        return view('collection.index', [
            'myGames' => $myGames,
            'availableGames' => $availableGames,
        ]);
    }

    // Game toevoegen aan mijn collectie
    public function store(Game $game)
    {
        // Alleen actieve games toevoegen
        abort_unless($game->is_active, 404);

        $user = auth()->user();

        // Voorkomen dat de game dubbel wordt toegevoegd
        if (!$user->games()->whereKey($game->id)->exists()) {

            $user->games()->attach($game->id, [
                'status' => 'wishlist',
            ]);

        }

        return redirect()
            ->route('collection.index')
            ->with('success', 'Game toegevoegd aan je collectie.');
    }

    // Status van mijn game aanpassen
    public function updateStatus(Request $request, Game $game)
    {
        // Controleren welke status is gekozen
        $validated = $request->validate([
            'status' => 'required|in:wishlist,playing,completed',
        ]);

        $user = auth()->user();

        // Controleren of deze game in mijn collectie staat
        $gameExists = $user->games()
            ->where('games.id', $game->id)
            ->exists();

        // Geen toegang als de game niet in mijn collectie staat
        abort_unless($gameExists, 403);

        // Status aanpassen in game_user
        $user->games()->updateExistingPivot($game->id, [
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('collection.index')
            ->with('success', 'Status is aangepast.');
    }

    // Game verwijderen uit mijn collectie
    public function destroy(Game $game)
    {
        auth()->user()->games()->detach($game->id);

        return redirect()
            ->route('collection.index')
            ->with('success', 'Game verwijderd uit je collectie.');
    }
}
