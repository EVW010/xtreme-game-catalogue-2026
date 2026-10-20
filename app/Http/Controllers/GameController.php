<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['genre', 'platforms'])->get();

        return view('games.index', [
            'games' => $games,
        ]);
    }

    public function create()
    {
        $genres = Genre::all();
        $platforms = Platform::all();

        return view('games.create', [
            'genres' => $genres,
            'platforms' => $platforms,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'developer' => [
                'required',
                'string',
                'max:255',
            ],

            'release_date' => [
                'required',
                'date',
            ],

            'genre_id' => [
                'required',
                'exists:genres,id',
            ],

            'platforms' => [
                'required',
                'array',
                'min:1',
            ],

            'platforms.*' => [
                'exists:platforms,id',
            ],
        ]);

        $game = new Game();

        $game->title = $validated['title'];
        $game->description = $validated['description'];
        $game->developer = $validated['developer'];
        $game->release_date = $validated['release_date'];

        // De ingelogde gebruiker is de uploader
        $game->user_id = auth()->id();

        // Gekozen genre
        $game->genre_id = $validated['genre_id'];

        $game->save();

        // Platforms opslaan in game_platform
        $game->platforms()->sync(
            $validated['platforms']
        );

        return redirect()
            ->route('games.index')
            ->with('success', 'Game is toegevoegd.');
    }

    public function edit(Game $game)
    {
        // Alleen de uploader of admin mag aanpassen
        abort_if(
            $game->user_id !== auth()->id()
            && auth()->user()->role !== 1,
            403
        );

        $genres = Genre::all();
        $platforms = Platform::all();

        return view('games.edit', [
            'game' => $game,
            'genres' => $genres,
            'platforms' => $platforms,
        ]);
    }

    public function update(Request $request, Game $game)
    {
        // Alleen de uploader of admin mag aanpassen
        abort_if(
            $game->user_id !== auth()->id()
            && auth()->user()->role !== 1,
            403
        );

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'developer' => [
                'required',
                'string',
                'max:255',
            ],

            'release_date' => [
                'required',
                'date',
            ],

            'genre_id' => [
                'required',
                'exists:genres,id',
            ],

            'platforms' => [
                'required',
                'array',
                'min:1',
            ],

            'platforms.*' => [
                'exists:platforms,id',
            ],
        ]);

        $game->title = $validated['title'];
        $game->description = $validated['description'];
        $game->developer = $validated['developer'];
        $game->release_date = $validated['release_date'];
        $game->genre_id = $validated['genre_id'];

        $game->save();

        // Platforms opnieuw koppelen
        $game->platforms()->sync(
            $validated['platforms']
        );

        return redirect()
            ->route('games.index')
            ->with('success', 'Game is aangepast.');
    }

    public function destroy(Game $game)
    {
        // Alleen de uploader of admin mag verwijderen
        abort_if(
            $game->user_id !== auth()->id()
            && auth()->user()->role !== 1,
            403
        );

        $game->delete();

        return redirect()
            ->route('games.index')
            ->with('success', 'Game is verwijderd.');
    }
}
