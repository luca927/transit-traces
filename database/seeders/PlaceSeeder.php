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
            'latitude' => 36.8,
            'longitude' => 43.1,
            'description' => 'Main camp entrance'
        ]);
        
        Place::create([
            'name' => 'Ahmed Bird Stall',
            'latitude' => 36.81,
            'longitude' => 43.11,
            'description' => '13yo bird entrepreneur'
        ]);
    }
}
