<?php
namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class FatmaSeeder extends Seeder
{
    public function run()
    {
        Place::create([
            'name' => 'Fatma Singing Spot',
            'latitude' => 36.82,
            'longitude' => 43.12,
            'description' => '16yo Youtuber spot'
        ]);
    }
}
