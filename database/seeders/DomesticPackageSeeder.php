<?php

namespace Database\Seeders;

use App\Models\DomesticPackage;
use Illuminate\Database\Seeder;

class DomesticPackageSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing data first to reload clean data
        DomesticPackage::truncate();

        $packages = [
            [
                'title'            => 'Kashmir',
                'subtitle'         => 'Discover the natural beauty of Kashmir with our carefully curated domestic tour.',
                'departure_city'   => 'Islamabad',
                'destination_city' => 'Kashmir',
                'hotel_name'       => 'Kashmir Serena Hotel',
                'hotel_rating'     => '4 star',
                'duration_days'    => 5,
                'price_per_person' => 45000.00,
                'travel_date_from' => '2026-09-01',
                'travel_date_to'   => '2026-09-06',
                'features'         => 'Luxury transport, Local tourist guide, Jeep safaris, Hotel stays',
                'requirements'     => 'CNIC copy, Warm clothes',
                'description'      => 'Discover the natural beauty of Kashmir with our carefully curated domestic tour. From stunning mountain peaks to lush green valleys, experience the best of Pakistan with comfortable stays, expert guides, and unforgettable adventures.',
                'image'            => 'kashmir.jpg',
                'status'           => 'active',
            ],
            [
                'title'            => 'Skardu',
                'subtitle'         => '7 Days Tour to Skardu & Deosai Plains',
                'departure_city'   => 'Islamabad',
                'destination_city' => 'Skardu',
                'hotel_name'       => 'Shangrila Resort',
                'hotel_rating'     => '4 star',
                'duration_days'    => 7,
                'price_per_person' => 65000.00,
                'travel_date_from' => '2026-09-10',
                'travel_date_to'   => '2026-09-17',
                'features'         => 'Standard transport, Hotel stays, Daily breakfast, Deosai tour',
                'requirements'     => 'CNIC copy, Warm clothing',
                'description'      => 'A breathtaking journey to Shangrila, Upper Kachura lake, Cold desert, Shigar fort, and Deosai plains.',
                'image'            => 'skardu.jpg',
                'status'           => 'active',
            ]
        ];

        foreach ($packages as $pkg) {
            DomesticPackage::create($pkg);
        }
    }
}
