<?php

namespace Database\Seeders;

use App\Models\VisaCountry;
use Illuminate\Database\Seeder;

class VisaCountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['country_name' => 'USA', 'country_code' => 'US', 'b2b_rate' => 'PKR 12,000/-', 'visa_fee' => '$185 (USD)'],
            ['country_name' => 'Canada', 'country_code' => 'CA', 'b2b_rate' => 'PKR 17,000/-', 'visa_fee' => '$185 (CAD)'],
            ['country_name' => 'Australia', 'country_code' => 'AU', 'b2b_rate' => 'PKR 17,000/-', 'visa_fee' => '$192 (AUD)'],
            ['country_name' => 'UK', 'country_code' => 'GB', 'b2b_rate' => 'PKR 17,000/-', 'visa_fee' => 'MIN: £115 - MAX £963'],
            ['country_name' => 'Italy', 'country_code' => 'IT', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Germany', 'country_code' => 'DE', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Netherlands', 'country_code' => 'NL', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Switzerland', 'country_code' => 'CH', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Czech Republic', 'country_code' => 'CZ', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Poland', 'country_code' => 'PL', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Austria', 'country_code' => 'AT', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Bulgaria', 'country_code' => 'BG', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Finland', 'country_code' => 'FI', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Belgium', 'country_code' => 'BE', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Norway', 'country_code' => 'NO', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'France', 'country_code' => 'FR', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Portugal', 'country_code' => 'PT', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Denmark', 'country_code' => 'DK', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Sweden', 'country_code' => 'SE', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Spain', 'country_code' => 'ES', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => '€90'],
            ['country_name' => 'Turkey', 'country_code' => 'TR', 'b2b_rate' => 'PKR 7,000/-', 'visa_fee' => '$158'],
            ['country_name' => 'Brazil', 'country_code' => 'BR', 'b2b_rate' => 'PKR 10,000/-', 'visa_fee' => '$90 (USD)'],
            ['country_name' => 'Egypt', 'country_code' => 'EG', 'b2b_rate' => 'PKR 8,000/-', 'visa_fee' => 'PKR 14,000/-'],
            ['country_name' => 'New Zealand', 'country_code' => 'NZ', 'b2b_rate' => 'PKR 17,000/-', 'visa_fee' => '$250 (USD)'],
            ['country_name' => 'South Korea', 'country_code' => 'KR', 'b2b_rate' => 'PKR 8,000/-', 'visa_fee' => 'PKR 13,000/-'],
            ['country_name' => 'Japan', 'country_code' => 'JP', 'b2b_rate' => 'PKR 10,000/-', 'visa_fee' => 'PKR 12,000/-', 'notes' => 'GERRYS'],
            ['country_name' => 'Mauritius', 'country_code' => 'MU', 'b2b_rate' => 'PKR 10,000/-', 'visa_fee' => 'PKR 3,300/-'],
            ['country_name' => 'Ireland', 'country_code' => 'IE', 'b2b_rate' => 'PKR 17,000/-', 'visa_fee' => 'C130'],
            ['country_name' => 'Morocco', 'country_code' => 'MA', 'b2b_rate' => 'PKR 10,000/-', 'visa_fee' => 'PKR 18,000/-'],
            ['country_name' => 'Afghanistan', 'country_code' => 'AF', 'b2b_rate' => 'PKR 6,000/-', 'visa_fee' => 'ASK & TELL'],
            ['country_name' => 'Bangladesh', 'country_code' => 'BD', 'b2b_rate' => 'PKR 15,000/-', 'visa_fee' => 'PKR 1,000/-'],
            ['country_name' => 'China', 'country_code' => 'CN', 'b2b_rate' => 'PKR 10,000/-', 'visa_fee' => 'PKR 7,000/-', 'notes' => 'GERRYS'],
            ['country_name' => 'Philippines', 'country_code' => 'PH', 'b2b_rate' => 'PKR 7,000/-', 'visa_fee' => 'PKR 8,700/-'],

            ['country_name' => 'Turkey E-Visa', 'country_code' => 'TR', 'b2b_rate' => null, 'visa_fee' => 'PKR 26,500/-'],
            ['country_name' => 'Thailand (Excluding Confirmed Ticket)', 'country_code' => 'TH', 'b2b_rate' => null, 'visa_fee' => 'PKR 16,500/-'],
            ['country_name' => 'Singapore E-Visa (Via Vendor)', 'country_code' => 'SG', 'b2b_rate' => null, 'visa_fee' => 'PKR 16,800/-'],
            ['country_name' => 'Singapore E-Visa (Via Consulate)', 'country_code' => 'SG', 'b2b_rate' => null, 'visa_fee' => 'PKR 14,000/-'],
            ['country_name' => 'Angola', 'country_code' => 'AO', 'b2b_rate' => null, 'visa_fee' => 'PKR 115,100/-'],
            ['country_name' => 'Hong Kong', 'country_code' => 'HK', 'b2b_rate' => null, 'visa_fee' => 'PKR 20,000/-'],
            ['country_name' => 'South Africa', 'country_code' => 'ZA', 'b2b_rate' => null, 'visa_fee' => 'PKR 29,000/-'],
            ['country_name' => 'Malawi', 'country_code' => 'MW', 'b2b_rate' => null, 'visa_fee' => 'PKR 29,600/-'],
            ['country_name' => 'VisaCountryonesia E-Visa', 'country_code' => 'ID', 'b2b_rate' => null, 'visa_fee' => 'PKR 26,000/-'],
            ['country_name' => 'Indonesia Sticker', 'country_code' => 'ID', 'b2b_rate' => null, 'visa_fee' => 'PKR 28,000/-'],
            ['country_name' => 'Kenya', 'country_code' => 'KE', 'b2b_rate' => null, 'visa_fee' => 'PKR 17,000/-'],
            ['country_name' => 'Malaysia (E-Visa)', 'country_code' => 'MY', 'b2b_rate' => null, 'visa_fee' => 'PKR 14,500/-'],
            ['country_name' => 'Malaysia (E-Visa Urgent)', 'country_code' => 'MY', 'b2b_rate' => null, 'visa_fee' => 'PKR 21,000/-'],
            ['country_name' => 'Myanmar', 'country_code' => 'MM', 'b2b_rate' => null, 'visa_fee' => 'PKR 53,500/-'],
            ['country_name' => 'Nigeria', 'country_code' => 'NG', 'b2b_rate' => null, 'visa_fee' => 'PKR 14,000/-'],
            ['country_name' => 'Baku Normal', 'country_code' => 'AZ', 'b2b_rate' => null, 'visa_fee' => 'PKR 13,000/-'],
            ['country_name' => 'Baku Urgent', 'country_code' => 'AZ', 'b2b_rate' => null, 'visa_fee' => 'PKR 26,000/-'],
            ['country_name' => 'Tajikistan', 'country_code' => 'TJ', 'b2b_rate' => null, 'visa_fee' => 'PKR 40,000/-'],
            ['country_name' => 'Sri Lanka E-Visa', 'country_code' => 'LK', 'b2b_rate' => null, 'visa_fee' => 'PKR 11,000/-'],
            ['country_name' => 'Tunisia', 'country_code' => 'TN', 'b2b_rate' => null, 'visa_fee' => 'PKR 43,150/-'],
            ['country_name' => 'Uzbekistan', 'country_code' => 'UZ', 'b2b_rate' => null, 'visa_fee' => 'PKR 38,000/-'],
            ['country_name' => 'Vietnam E-Visa', 'country_code' => 'VN', 'b2b_rate' => null, 'visa_fee' => 'PKR 15,000/-'],
            ['country_name' => 'Colombia', 'country_code' => 'CO', 'b2b_rate' => null, 'visa_fee' => 'PKR 12,000/-'],
            ['country_name' => 'Pakistan E-Visa', 'country_code' => 'PK', 'b2b_rate' => null, 'visa_fee' => 'PKR 10,000/-'],
            ['country_name' => 'Tanzania E-Visa', 'country_code' => 'TZ', 'b2b_rate' => null, 'visa_fee' => 'PKR 25,000/-'],
            ['country_name' => 'Zambia', 'country_code' => 'ZM', 'b2b_rate' => null, 'visa_fee' => 'PKR 17,000/-'],
            ['country_name' => 'Cambodia', 'country_code' => 'KH', 'b2b_rate' => null, 'visa_fee' => 'PKR 15,000/-'],
            ['country_name' => 'Bahrain', 'country_code' => 'BH', 'b2b_rate' => null, 'visa_fee' => 'PKR 20,000/-'],
        ];

        $defaultRequirements = [
            'Valid Passport',
            'Picture with White Background',
            'CNIC Front & Back',
            'Bank Statement',
            'Other Documents',
        ];

        foreach ($countries as $row) {
            $country = VisaCountry::updateOrCreate(
                ['country_name' => $row['country_name']],
                [
                    'country_code' => $row['country_code'],
                    'is_active' => true,
                ]
            );

            $country->visaTypes()->updateOrCreate(
                ['visa_name' => 'Standard'],
                [
                    'b2b_rate'         => $row['b2b_rate'],
                    'visa_fee'         => $row['visa_fee'],
                    'process_time'  => '30 Days',
                    'requirements'     => $defaultRequirements,
                    'notes'            => $row['notes'] ?? null,
                    'is_active'        => true,
                ]
            );
        }
    }
}