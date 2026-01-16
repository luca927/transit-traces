<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::create(['name'=>'Ahmed', 'surname'=>'Al-Kurdi', 'biography'=>'13yo bird entrepreneur']);
        Person::create(['name'=>'Fatma', 'surname'=>'Hassan', 'biography'=>'16yo Youtuber singer']);  
        Person::create(['name'=>'Omar', 'surname'=>'', 'biography'=>'Water distribution volunteer']);
    
    }
}
