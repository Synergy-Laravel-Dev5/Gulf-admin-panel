<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Makkah',    'country' => 'Saudi Arabia'],
            ['name' => 'Madinah',   'country' => 'Saudi Arabia'],
            ['name' => 'Azizia',    'country' => 'Saudi Arabia'],
            ['name' => 'Jeddah',    'country' => 'Saudi Arabia'],
            ['name' => 'Riyadh',    'country' => 'Saudi Arabia'],
            ['name' => 'Dubai',     'country' => 'UAE'],
            ['name' => 'Istanbul',  'country' => 'Turkey'],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(
                ['name' => $city['name']],
                ['country' => $city['country'], 'status' => 'active']
            );
        }
    }
}
