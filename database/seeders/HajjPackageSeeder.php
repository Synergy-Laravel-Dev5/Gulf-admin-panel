<?php

namespace Database\Seeders;

use App\Models\HajjPackage;
use Illuminate\Database\Seeder;

class HajjPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'title'                  => 'Premium Hajj Package 2026',
                'subtitle'               => '5 Star Executive Hajj Experience',
                'maktab_category'        => 'Category A (VIP)',
                'zone'                   => 'Zone 1 (Near Jamarat)',
                'no_of_days'             => '15 Days',
                
                'makkah_hotel_name'      => 'Swissôtel Makkah',
                'makkah_hotel_distance'  => '100 Meters',
                'makkah_hotel_period'    => '15 Zil Qadda to 25 Zil Qadda',
                'makkah_hotel_meal_plan' => 'Full Board',
                'makkah_hotel_category'  => '5 Star',
                
                'madinah_hotel_name'     => 'Anwar Al Madinah Mövenpick',
                'madinah_hotel_distance' => '50 Meters',
                'madinah_hotel_period'   => '25 Zil Qadda to 05 Zil Hujja',
                'madinah_hotel_meal_plan'=> 'Full Board',
                'madinah_hotel_category' => '5 Star',
                
                'azizia_hotel_name'      => 'Al-Kiswah Towers Azizia',
                'azizia_hotel_distance'  => '2 KM',
                'azizia_hotel_period'    => '05 Zil Hujja to 15 Zil Qadda',
                'azizia_hotel_meal_plan' => 'Half Board',
                'azizia_hotel_category'  => 'Premium Building',
                
                'price_sharing'          => 4500.00,
                'price_triple'           => 5200.00,
                'price_double'           => 6000.00,
                'travel_date_from'       => '2026-05-15',
                'travel_date_to'         => '2026-05-30',
                
                'qurbani'                => 'Included',
                'airline_ticket'         => 'Direct Airline',
                'ziarat'                 => 'Included',

                'transportation_route'   => 'jeddah_makkah_madinah_jeddah',
                'trans_jeddah_makkah'    => 'Private Car',
                'trans_makkah_madinah'   => 'Train',
                'trans_madinah_jeddah'   => 'Private Car',
                
                'features'               => '<ul><li>VIP Air-conditioned Tents in Arafat & Mina</li><li>Private Transportations</li><li>Religious Guides (Moallim)</li></ul>',
                'requirements'           => ['Valid Passport', 'Picture with White Background', 'CNIC Front & Back', 'Hajj Registration Receipt'],
                'description'            => '<p>Experience a peaceful and luxurious Hajj with our Premium package. All logistics are managed by our professional team.</p>',
                'status'                 => 'active',
            ],
            [
                'title'                  => 'Economy Hajj Package 2026',
                'subtitle'               => 'Affordable & Convenient Hajj Journey',
                'maktab_category'        => 'Category D',
                'zone'                   => 'Zone 3',
                'no_of_days'             => '40 Days',
                
                'makkah_hotel_name'      => 'Fajar Badee 5',
                'makkah_hotel_distance'  => '550 Meters',
                'makkah_hotel_period'    => '10 Zil Qadda to 25 Zil Qadda',
                'makkah_hotel_meal_plan' => 'Half Board',
                'makkah_hotel_category'  => '3 Star',
                
                'madinah_hotel_name'     => 'Taif Al Nibras',
                'madinah_hotel_distance' => '200 Meters',
                'madinah_hotel_period'   => '25 Zil Qadda to 05 Zil Hujja',
                'madinah_hotel_meal_plan'=> 'Half Board',
                'madinah_hotel_category' => '3 Star',
                
                'azizia_hotel_name'      => 'Dar Al-Hadi Azizia',
                'azizia_hotel_distance'  => '2.2 KM',
                'azizia_hotel_period'    => '05 Zil Hujja to 15 Zil Qadda',
                'azizia_hotel_meal_plan' => 'Room Only',
                'azizia_hotel_category'  => 'Standard Building',
                
                'price_sharing'          => 2800.00,
                'price_triple'           => 3300.00,
                'price_double'           => 3800.00,
                'travel_date_from'       => '2026-05-10',
                'travel_date_to'         => '2026-06-20',
                
                'qurbani'                => 'Not Included',
                'airline_ticket'         => 'Indirect Airline',
                'ziarat'                 => 'Included',

                'transportation_route'   => 'custom',
                'trans_jeddah_makkah'    => 'Bus',
                'trans_makkah_madinah'   => 'Bus',
                'trans_madinah_makkah'   => 'Bus',
                'trans_makkah_jeddah'    => 'Bus',
                'trans_madinah_madinah'  => 'Bus',
                'trans_madinah_jeddah'   => 'Bus',
                
                'features'               => '<ul><li>Standard Tents in Mina</li><li>Shared Shuttle Services</li><li>Buffet Meals</li></ul>',
                'requirements'           => ['Valid Passport', 'Picture with White Background', 'CNIC Front & Back'],
                'description'            => '<p>Our Economy Package provides comfortable accommodation at affordable rates, ensuring all essential religious services are met.</p>',
                'status'                 => 'active',
            ]
        ];

        foreach ($packages as $pkg) {
            HajjPackage::firstOrCreate(
                ['title' => $pkg['title']],
                $pkg
            );
        }
    }
}
