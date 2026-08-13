<?php

namespace Database\Seeders;

use App\Models\InternationalPackage;
use Illuminate\Database\Seeder;

class InternationalPackageSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing data first to reload clean data
        InternationalPackage::truncate();

        $packages = [
            [
                'title'               => 'Dubai',
                'subtitle'            => '6 Days Dubai City Experience',
                'departure_city'      => 'Karachi',
                'destination_country' => 'UAE',
                'destination_city'    => 'Dubai',
                'hotel_name'          => 'Radisson Red Dubai',
                'star_rating'         => '4',
                'visa_required'       => true,
                'duration_days'       => 6,
                'price_per_person'    => 180000.00,
                'travel_date_from'    => '2026-10-10',
                'travel_date_to'      => '2026-10-16',
                'features'            => 'Visa processing, Desert Safari with BBQ, Dhow Cruise dinner',
                'requirements'        => 'Valid Passport, Passport size photo',
                'description'         => 'Enjoy a shopping and leisure tour in Dubai, including Burj Khalifa entry, desert safari, and theme parks.',
                'image'               => 'dubai.jpg',
                'status'              => 'active',
            ],
            [
                'title'               => 'Makkah',
                'subtitle'            => '10 Days Premium Umrah Package',
                'departure_city'      => 'Karachi',
                'destination_country' => 'Saudi Arabia',
                'destination_city'    => 'Makkah',
                'hotel_name'          => 'Fairmont Makkah Clock Royal Tower',
                'star_rating'         => '5',
                'visa_required'       => true,
                'duration_days'       => 10,
                'price_per_person'    => 250000.00,
                'travel_date_from'    => '2026-11-01',
                'travel_date_to'      => '2026-11-11',
                'features'            => 'Umrah Visa, Luxury transport, Hotel near Haram, Daily breakfast',
                'requirements'        => 'Passport valid for 6 months, Covid Vaccination Certificate',
                'description'         => 'Perform Umrah with extreme comfort and peace of mind in our premium Makkah and Madinah package.',
                'image'               => 'makkah.jpg',
                'status'              => 'active',
            ]
        ];

        foreach ($packages as $pkg) {
            InternationalPackage::create($pkg);
        }
    }
}
