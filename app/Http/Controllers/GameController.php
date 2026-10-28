<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Games bekijken, zoeken en filteren
    public function index(Request $request)
    {
        $games = Game::with(['genre', 'platforms']);

        // Bezoekers zien alleen actieve games
        if (!auth()->check()) {
            $games->where('is_active', true);
        } elseif (auth()->user()->role !== 1) {

            // Gebruikers zien actieve games en hun eigen games
            $games->where(function ($query) {
                $query->where('is_active', true)
                    ->orWhere('user_id', auth()->id());
            });
        }

        // Zoeken op titel, beschrijving en developer
        if ($request->filled('search')) {
            $search = $request->input('search');

            $games->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('developer', 'like', '%' . $search . '%');
            });
        }

        // Filteren op genre
        if ($request->filled('genre_id')) {
            $games->where('genre_id', $request->input('genre_id'));
        }

        // Filteren op platform
        if ($request->filled('platform_id')) {
            $platformId = $request->input('platform_id');

            $games->whereHas('platforms', function ($query) use ($platformId) {
                $query->where('platforms.id', $platformId);
            });
        }

        // Games ophalen
        $games = $games->get();

        // Alle genres en platforms ophalen
        $genres = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();

        return view('games.index', [
            'games' => $games,
            'genres' => $genres,
            'platforms' => $platforms,
        ]);
    }

    // Formulier voor nieuwe game
    public function create()
    {
        $genres = Genre::all();
        $platforms = Platform::all();

        return view('games.create', [
            'genres' => $genres,
            'platforms' => $platforms,
        ]);
    }

    // Nieuwe game opslaan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'developer' => 'required|string|max:255',
            'release_date' => 'required|date',
            'genre_id' => 'required|exists:genres,id',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'exists:platforms,id',
        ]);

        $game = new Game();

        $game->title = $validated['title'];
        $game->description = $validated['description'];
        $game->developer = $validated['developer'];
        $game->release_date = $validated['release_date'];
        $game->genre_id = $validated['genre_id'];
        $game->user_id = auth()->id();

        $game->save();

        // Platforms koppelen
        $game->platforms()->sync($validated['platforms']);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game is toegevoegd.');
    }

    // Game bewerken
    public function edit(Game $game)
    {
        // Alleen de eigenaar mag bewerken
        abort_if($game->user_id !== auth()->id(), 403);

        $genres = Genre::all();
        $platforms = Platform::all();

        return view('games.edit', [
            'game' => $game,
            'genres' => $genres,
            'platforms' => $platforms,
        ]);
    }

    // Game aanpassen
    public function update(Request $request, Game $game)
    {
        // Alleen de eigenaar mag aanpassen
        abort_if($game->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'developer' => 'required|string|max:255',
            'release_date' => 'required|date',
            'genre_id' => 'required|exists:genres,id',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'exists:platforms,id',
        ]);

        $game->title = $validated['title'];
        $game->description = $validated['description'];
        $game->developer = $validated['developer'];
        $game->release_date = $validated['release_date'];
        $game->genre_id = $validated['genre_id'];

        $game->save();

        // Platforms aanpassen
        $game->platforms()->sync($validated['platforms']);

        return redirect()
            ->route('games.index')
            ->with('success', 'Game is aangepast.');
    }

    // Game verwijderen
    public function destroy(Game $game)
    {
        // Alleen de eigenaar mag verwijderen
        abort_if($game->user_id !== auth()->id(), 403);

        $game->delete();

        return redirect()
            ->route('games.index')
            ->with('success', 'Game is verwijderd.');
    }

    // Game activeren of deactiveren
    public function toggleActive(Game $game)
    {
        // Alleen admin mag dit
        abort_unless(auth()->user()?->role === 1, 403);

        $game->is_active = !$game->is_active;
        $game->save();

        return redirect()
            ->route('games.index')
            ->with('success', 'Status is aangepast.');
    }
}
