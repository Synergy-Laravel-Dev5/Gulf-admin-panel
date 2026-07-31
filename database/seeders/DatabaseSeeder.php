<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VisaCountrySeeder::class,
            CitySeeder::class,
            HotelSeeder::class,
            HajjPackageSeeder::class,
            UmrahPackageSeeder::class,
            DomesticPackageSeeder::class,
            InternationalPackageSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('Admin@12345'),
                'status'   => 'active',
                'role'     => 'admin',
            ]
        );
    }
}
