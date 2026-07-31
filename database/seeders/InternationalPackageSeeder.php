<?php

namespace Database\Seeders;

use App\Models\InternationalPackage;
use Illuminate\Database\Seeder;

class InternationalPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'title'               => 'Baku Luxury Tour 2026',
                'subtitle'            => '5 Days Tour to Baku & Gabala',
                'departure_city'      => 'Karachi',
                'destination_country' => 'Azerbaijan',
                'destination_city'    => 'Baku',
                'hotel_name'          => 'Hilton Baku',
                'star_rating'         => '5',
                'visa_required'       => true,
                'duration_days'       => 5,
                'price_per_person'    => 1200.00,
                'travel_date_from'    => '2026-10-01',
                'travel_date_to'      => '2026-10-06',
                'features'            => '<ul><li>E-visa Included</li><li>Airport transfers</li><li>Gabala day excursion</li></ul>',
                'requirements'        => ['Valid Passport', 'CNIC front/back', 'Passport-sized photo'],
                'description'         => 'Spend 5 days exploring Baku, Gabala, Mud Volcanoes, Yanardag, and the historic old city.',
                'status'              => 'active',
            ],
            [
                'title'               => 'Dubai Explorer Package 2026',
                'subtitle'            => '6 Days Dubai City Experience',
                'departure_city'      => 'Lahore',
                'destination_country' => 'UAE',
                'destination_city'    => 'Dubai',
                'hotel_name'          => 'Radisson Red Dubai',
                'star_rating'         => '4',
                'visa_required'       => true,
                'duration_days'       => 6,
                'price_per_person'    => 899.00,
                'travel_date_from'    => '2026-10-10',
                'travel_date_to'      => '2026-10-16',
                'features'            => '<ul><li>Visa processing</li><li>Desert Safari with BBQ</li><li>Dhow Cruise dinner</li></ul>',
                'requirements'        => ['Valid Passport', 'Passport size photo', 'Bank statement (optional)'],
                'description'         => 'Enjoy a shopping and leisure tour in Dubai, including Burj Khalifa entry, desert safari, and theme parks.',
                'status'              => 'active',
            ]
        ];

        foreach ($packages as $pkg) {
            InternationalPackage::firstOrCreate(
                ['title' => $pkg['title']],
                $pkg
            );
        }
    }
}
