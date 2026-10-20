<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $games = [
            [
                'title' => 'Minecraft',
                'genre' => 'Sandbox',
                'platform' => 'PC'
            ],
            [
                'title' => 'The Witcher 3',
                'genre' => 'RPG',
                'platform' => 'PC'
            ],
            [
                'title' => 'Mario Kart 8',
                'genre' => 'Racing',
                'platform' => 'Nintendo Switch'
            ]
        ];

        return view('home', [
            'games' => $games
        ]);
    }
}
