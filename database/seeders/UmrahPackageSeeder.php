<?php

namespace Database\Seeders;

use App\Models\UmrahPackage;
use Illuminate\Database\Seeder;

class UmrahPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'title'                  => 'Deluxe Umrah Package 2026',
                'subtitle'               => 'Comfortable 10-day Umrah Trip',
                'makkah_hotel_name'      => 'Anjum Makkah Hotel',
                'makkah_hotel_distance'  => '300 Meters',
                'madinah_hotel_name'     => 'Anwar Al Madinah Mövenpick',
                'madinah_hotel_distance' => '50 Meters',
                'price_sharing'          => 1500.00,
                'price_triple'           => 1800.00,
                'price_double'           => 2200.00,
                'durations'              => [
                    '10' => ['enabled' => true, 'days' => 10, 'price_sharing' => 1500, 'price_triple' => 1800, 'price_double' => 2200],
                    '15' => ['enabled' => true, 'days' => 15, 'price_sharing' => 1800, 'price_triple' => 2100, 'price_double' => 2500],
                    '20' => ['enabled' => true, 'days' => 20, 'price_sharing' => 2200, 'price_triple' => 2600, 'price_double' => 3000],
                    '28' => ['enabled' => true, 'days' => 28, 'price_sharing' => 2800, 'price_triple' => 3300, 'price_double' => 3800],
                ],
                'travel_date_from'       => '2026-08-01',
                'travel_date_to'         => '2026-08-10',
                'features'               => '<ul><li>Visa Processing</li><li>Meet & Assist at Airport</li><li>Ziarat in Makkah & Madinah</li></ul>',
                'requirements'           => "Valid Passport\nVaccination Certificate\nCNIC Copy",
                'description'            => 'Join our Deluxe Umrah Package for a spiritually fulfilling and stress-free journey.',
                'status'                 => 'active',
            ],
            [
                'title'                  => 'Economy Umrah Package 2026',
                'subtitle'               => 'Affordable 15-day Umrah Trip',
                'makkah_hotel_name'      => 'Fajar Badee 5',
                'makkah_hotel_distance'  => '550 Meters',
                'madinah_hotel_name'     => 'Al Aqeeq Hotel',
                'madinah_hotel_distance' => '350 Meters',
                'price_sharing'          => 1100.00,
                'price_triple'           => 1300.00,
                'price_double'           => 1600.00,
                'durations'              => [
                    '10' => ['enabled' => true, 'days' => 10, 'price_sharing' => 1100, 'price_triple' => 1300, 'price_double' => 1600],
                    '15' => ['enabled' => true, 'days' => 15, 'price_sharing' => 1350, 'price_triple' => 1550, 'price_double' => 1900],
                ],
                'travel_date_from'       => '2026-08-15',
                'travel_date_to'         => '2026-08-30',
                'features'               => '<ul><li>Visa Processing</li><li>Shared Transport</li><li>Economy Hotel Stays</li></ul>',
                'requirements'           => "Valid Passport\nVaccination Certificate\nCNIC Copy",
                'description'            => 'Perform your Umrah at budget-friendly rates with our Economy package.',
                'status'                 => 'active',
            ]
        ];

        foreach ($packages as $pkg) {
            $existing = UmrahPackage::where('title', $pkg['title'])->first();
            if ($existing) {
                $existing->update($pkg);
            } else {
                UmrahPackage::create($pkg);
            }
        }
    }
}
