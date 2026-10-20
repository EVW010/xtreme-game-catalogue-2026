<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            'PC',
            'PlayStation 5',
            'Xbox Series X',
            'Nintendo Switch',
        ];

        foreach ($platforms as $platform) {
            Platform::firstOrCreate([
                'name' => $platform,
            ]);
        }
    }
}
