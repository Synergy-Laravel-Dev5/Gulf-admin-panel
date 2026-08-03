<?php

namespace Database\Seeders;

use App\Models\TransportationRoute;
use Illuminate\Database\Seeder;

class TransportationRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'name' => 'Jeddah Airport -> Makkah Hotel -> Medina Hotel -> Jeddah Airport',
                'code' => 'jeddah_makkah_madinah_jeddah',
            ],
            [
                'name' => 'Jeddah Airport -> Makkah Hotel -> Medina Hotel -> Medina Airport',
                'code' => 'jeddah_makkah_madinah_madinah',
            ],
            [
                'name' => 'Madinah Airport -> Madinah Hotel -> Makkah Hotel -> Jeddah Airport',
                'code' => 'madinah_madinah_makkah_jeddah',
            ],
            [
                'name' => 'Jeddah Airport -> Makkah Hotel -> Jeddah Airport',
                'code' => 'jeddah_makkah_jeddah',
            ],
            [
                'name' => 'Madinah Airport -> Madinah Hotel -> Makkah Hotel -> Medina Airport',
                'code' => 'madinah_madinah_makkah_madinah',
            ],
            [
                'name' => 'Custom Route (Show All Route Options)',
                'code' => 'custom',
            ],
        ];

        foreach ($routes as $route) {
            TransportationRoute::firstOrCreate(
                ['code' => $route['code']],
                ['name' => $route['name'], 'status' => 'active']
            );
        }
    }
}
