<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            ['name' => 'Anjum Makkah',   'city' => 'makkah',  'distance' => 'Full Board',   'star_rating' => '5'],
            ['name' => 'Fajar Badee 5',  'city' => 'makkah',  'distance' => '550 Meters',   'star_rating' => '3'],
            ['name' => 'Swissotel Al Maqam', 'city' => 'makkah', 'distance' => '250 Meters', 'star_rating' => '5'],
            ['name' => 'Elaf Kinda',     'city' => 'makkah',  'distance' => '400 Meters',   'star_rating' => '4'],
            ['name' => 'Al Shohada Hotel', 'city' => 'makkah', 'distance' => '700 Meters',  'star_rating' => '3'],

            ['name' => 'Markazia',       'city' => 'madinah', 'distance' => '100-300 Meters Approx', 'star_rating' => '4'],
            ['name' => 'Taif Al Nibras', 'city' => 'madinah', 'distance' => '200 Meters',   'star_rating' => '3'],
            ['name' => 'Dar Al Taqwa',   'city' => 'madinah', 'distance' => '150 Meters',   'star_rating' => '4'],
            ['name' => 'Al Aqeeq Hotel', 'city' => 'madinah', 'distance' => '350 Meters',   'star_rating' => '3'],
            ['name' => 'Anwar Al Madinah Mövenpick', 'city' => 'madinah', 'distance' => '50 Meters', 'star_rating' => '5'],
        ];

        foreach ($hotels as $hotel) {
            Hotel::firstOrCreate(
                ['name' => $hotel['name'], 'city' => $hotel['city']],
                array_merge($hotel, ['status' => 'active'])
            );
        }
    }
}
