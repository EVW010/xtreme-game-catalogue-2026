<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@example.com')->firstOrFail();

        /*
         * Minecraft
         */
        $minecraft = Game::firstOrNew([
            'title' => 'Minecraft',
        ]);

        $minecraft->description = 'Een sandbox game waarin je kunt bouwen, ontdekken en overleven.';
        $minecraft->developer = 'Mojang Studios';
        $minecraft->release_date = '2011-11-18';

        $minecraft->user()->associate($user);

        $minecraft->genre()->associate(
            Genre::where('name', 'Sandbox')->firstOrFail()
        );

        $minecraft->save();

        $minecraft->platforms()->sync(
            Platform::whereIn('name', [
                'PC',
                'PlayStation 5',
                'Xbox Series X',
                'Nintendo Switch',
            ])->pluck('id')
        );


        /*
         * The Witcher 3
         */
        $witcher = Game::firstOrNew([
            'title' => 'The Witcher 3',
        ]);

        $witcher->description = 'Een open-world RPG waarin je speelt als monsterjager Geralt.';
        $witcher->developer = 'CD Projekt Red';
        $witcher->release_date = '2015-05-19';

        $witcher->user()->associate($user);

        $witcher->genre()->associate(
            Genre::where('name', 'RPG')->firstOrFail()
        );

        $witcher->save();

        $witcher->platforms()->sync(
            Platform::whereIn('name', [
                'PC',
                'PlayStation 5',
                'Xbox Series X',
                'Nintendo Switch',
            ])->pluck('id')
        );


        /*
         * Mario Kart 8 Deluxe
         */
        $marioKart = Game::firstOrNew([
            'title' => 'Mario Kart 8 Deluxe',
        ]);

        $marioKart->description = 'Een racing game met personages uit de Mario-serie.';
        $marioKart->developer = 'Nintendo';
        $marioKart->release_date = '2017-04-28';

        $marioKart->user()->associate($user);

        $marioKart->genre()->associate(
            Genre::where('name', 'Racing')->firstOrFail()
        );

        $marioKart->save();

        $marioKart->platforms()->sync(
            Platform::where('name', 'Nintendo Switch')->pluck('id')
        );
    }
}
