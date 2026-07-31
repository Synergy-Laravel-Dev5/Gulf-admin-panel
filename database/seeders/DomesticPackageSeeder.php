<?php

namespace Database\Seeders;

use App\Models\DomesticPackage;
use Illuminate\Database\Seeder;

class DomesticPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'title'            => 'Hunza Valley Discovery Tour',
                'subtitle'         => '5 Days Scenic Tour to Karakoram',
                'departure_city'   => 'Islamabad',
                'destination_city' => 'Hunza Valley',
                'hotel_name'       => 'Serena Altit Fort Residence',
                'hotel_rating'     => '4 star',
                'duration_days'    => 5,
                'price_per_person' => 450.00,
                'travel_date_from' => '2026-09-01',
                'travel_date_to'   => '2026-09-05',
                'features'         => '<ul><li>Luxury transport</li><li>Local tourist guide</li><li>Jeep safaris</li></ul>',
                'requirements'     => ['CNIC copy', 'Warm clothes', 'Comfortable trekking shoes'],
                'description'      => 'Explore the beautiful Hunza valley, visiting Altit and Baltit forts, Attabad lake, and Karimabad bazaar.',
                'status'           => 'active',
            ],
            [
                'title'            => 'Skardu Valley Adventure',
                'subtitle'         => '7 Days Tour to Skardu & Deosai Plains',
                'departure_city'   => 'Islamabad',
                'destination_city' => 'Skardu',
                'hotel_name'       => 'Shangrila Resort',
                'hotel_rating'     => '4 star',
                'duration_days'    => 7,
                'price_per_person' => 650.00,
                'travel_date_from' => '2026-09-10',
                'travel_date_to'   => '2026-09-17',
                'features'         => '<ul><li>Standard transport</li><li>Hotel stays</li><li>Daily breakfast</li></ul>',
                'requirements'     => ['CNIC copy', 'Warm clothing'],
                'description'      => 'A breathtaking journey to Shangrila, Upper Kachura lake, Cold desert, Shigar fort, and Deosai plains.',
                'status'           => 'active',
            ]
        ];

        foreach ($packages as $pkg) {
            DomesticPackage::firstOrCreate(
                ['title' => $pkg['title']],
                $pkg
            );
        }
    }
}
