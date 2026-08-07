<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            // Makkah Hotels
            ['name' => 'Swissôtel Makkah',              'city' => 'makkah',   'distance' => '100 Meters', 'star_rating' => '5'],
            ['name' => 'Anjum Makkah Hotel',            'city' => 'makkah',   'distance' => '300 Meters', 'star_rating' => '5'],
            ['name' => 'Pullman Zamzam Makkah',         'city' => 'makkah',   'distance' => '150 Meters', 'star_rating' => '5'],
            ['name' => 'Makkah Hotel & Towers',         'city' => 'makkah',   'distance' => '200 Meters', 'star_rating' => '4'],
            ['name' => 'Elaf Kinda Hotel',              'city' => 'makkah',   'distance' => '400 Meters', 'star_rating' => '4'],
            ['name' => 'Fajar Badee 5',                 'city' => 'makkah',   'distance' => '550 Meters', 'star_rating' => '3'],
            ['name' => 'Al Shohada Hotel',              'city' => 'makkah',   'distance' => '700 Meters', 'star_rating' => '3'],

            // Madinah Hotels
            ['name' => 'Dar Al Taqwa Hotel',            'city' => 'madinah',  'distance' => '50 Meters',  'star_rating' => '5'],
            ['name' => 'Anwar Al Madinah Mövenpick',    'city' => 'madinah',  'distance' => '50 Meters',  'star_rating' => '5'],
            ['name' => 'Oberoi Madinah',                'city' => 'madinah',  'distance' => '100 Meters', 'star_rating' => '5'],
            ['name' => 'Markazia Hotel',                'city' => 'madinah',  'distance' => '200 Meters', 'star_rating' => '4'],
            ['name' => 'Frontel Al Harithia',           'city' => 'madinah',  'distance' => '250 Meters', 'star_rating' => '4'],
            ['name' => 'Taif Al Nibras',                'city' => 'madinah',  'distance' => '200 Meters', 'star_rating' => '3'],
            ['name' => 'Al Aqeeq Hotel',                'city' => 'madinah',  'distance' => '350 Meters', 'star_rating' => '3'],

            // Azizia Hotels
            ['name' => 'Al-Kiswah Towers Azizia',       'city' => 'azizia',   'distance' => '2 KM',       'star_rating' => '4'],
            ['name' => 'Azizia Grand Hotel',            'city' => 'azizia',   'distance' => '1.5 KM',     'star_rating' => '3'],
            ['name' => 'Dar Al-Hadi Azizia',            'city' => 'azizia',   'distance' => '2.2 KM',     'star_rating' => '3'],

            // Jeddah Hotels
            ['name' => 'Jeddah Hilton',                 'city' => 'jeddah',   'distance' => 'Corniche Road', 'star_rating' => '5'],
            ['name' => 'Rosewood Jeddah',               'city' => 'jeddah',   'distance' => 'Corniche Road', 'star_rating' => '5'],
            ['name' => 'Radisson Blu Hotel Jeddah',     'city' => 'jeddah',   'distance' => 'City Center',   'star_rating' => '4'],

            // Riyadh Hotels
            ['name' => 'The Ritz-Carlton Riyadh',       'city' => 'riyadh',   'distance' => 'Al Hada Area',  'star_rating' => '5'],
            ['name' => 'Four Seasons Hotel Riyadh',     'city' => 'riyadh',   'distance' => 'Kingdom Tower', 'star_rating' => '5'],
            ['name' => 'Holiday Inn Riyadh',            'city' => 'riyadh',   'distance' => 'Olaya District','star_rating' => '4'],

            // Dubai Hotels
            ['name' => 'Burj Al Arab',                  'city' => 'dubai',    'distance' => 'Jumeirah Beach','star_rating' => '5'],
            ['name' => 'Atlantis The Palm',             'city' => 'dubai',    'distance' => 'Palm Jumeirah', 'star_rating' => '5'],
            ['name' => 'Citymax Hotel Bur Dubai',       'city' => 'dubai',    'distance' => 'Bur Dubai',     'star_rating' => '3'],

            // Istanbul Hotels
            ['name' => 'Ciragan Palace Kempinski',      'city' => 'istanbul', 'distance' => 'Bosphorus',     'star_rating' => '5'],
            ['name' => 'Swissotel The Bosphorus',       'city' => 'istanbul', 'distance' => 'City Center',   'star_rating' => '5'],
        ];

        foreach ($hotels as $hotel) {
            $cityImage = strtolower($hotel['city']) . '.jpg';
            Hotel::firstOrCreate(
                ['name' => $hotel['name'], 'city' => $hotel['city']],
                array_merge($hotel, ['status' => 'active', 'image' => $cityImage])
            );
        }

        $existingHotels = Hotel::all();
        foreach ($existingHotels as $eh) {
            $cityImage = strtolower($eh->city) . '.jpg';
            if (!file_exists(public_path('assets/images/hotels/' . $cityImage))) {
                $cityImage = 'default_hotel.jpg';
            }
            $eh->update(['image' => $cityImage]);
        }
    }
}
