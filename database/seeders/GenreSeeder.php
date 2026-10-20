<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action',
            'Adventure',
            'RPG',
            'Racing',
            'Sandbox',
            'Horror',
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate([
                'name' => $genre,
            ]);
        }
    }
}
