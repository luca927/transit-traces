<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place; 

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Place::create([
        'name' => 'Domiz Entrance',
        'latitude' => 36.80,
        'longitude' => 43.10,
        'description' => 'Ingresso campo',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4'
    ]);

    Place::create([
        'name' => 'Ahmed Stall',
        'latitude' => 36.81,
        'longitude' => 43.11,
        'description' => 'Banco uccelli Ahmed',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4'
    ]);

    Place::create([
        'name' => 'Fatma Spot',
        'latitude' => 36.82,
        'longitude' => 43.12,
        'description' => 'Punto Fatma',
        'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4'
    ]);

    }
}
