<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('transportations');

        Schema::table('hajj_packages', function (Blueprint $table) {
            $table->string('maktab_category')->nullable()->after('subtitle');
            $table->string('zone')->nullable()->after('maktab_category');
            $table->string('no_of_days')->nullable()->after('zone');
            
            $table->string('makkah_hotel_period')->nullable()->after('makkah_hotel_distance');
            $table->string('makkah_hotel_meal_plan')->nullable()->after('makkah_hotel_period');
            $table->string('makkah_hotel_category')->nullable()->after('makkah_hotel_meal_plan');

            $table->string('madinah_hotel_period')->nullable()->after('madinah_hotel_distance');
            $table->string('madinah_hotel_meal_plan')->nullable()->after('madinah_hotel_period');
            $table->string('madinah_hotel_category')->nullable()->after('madinah_hotel_meal_plan');

            $table->string('azizia_hotel_name')->nullable()->after('madinah_hotel_category');
            $table->string('azizia_hotel_period')->nullable()->after('azizia_hotel_name');
            $table->string('azizia_hotel_meal_plan')->nullable()->after('azizia_hotel_period');
            $table->string('azizia_hotel_distance')->nullable()->after('azizia_hotel_meal_plan');
            $table->string('azizia_hotel_category')->nullable()->after('azizia_hotel_distance');

            $table->string('qurbani')->nullable()->after('price_double');
            $table->string('airline_ticket')->nullable()->after('qurbani');

            $table->string('transportation_route')->nullable()->after('airline_ticket');
            $table->string('trans_jeddah_makkah')->nullable()->after('transportation_route');
            $table->string('trans_makkah_madinah')->nullable()->after('trans_jeddah_makkah');
            $table->string('trans_madinah_makkah')->nullable()->after('trans_makkah_madinah');
            $table->string('trans_makkah_jeddah')->nullable()->after('trans_madinah_makkah');
            $table->string('trans_madinah_madinah')->nullable()->after('trans_makkah_jeddah');
            $table->string('trans_madinah_jeddah')->nullable()->after('trans_madinah_madinah');

            $table->string('ziarat')->nullable()->after('trans_madinah_jeddah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hajj_packages', function (Blueprint $table) {
            $table->dropColumn([
                'maktab_category',
                'zone',
                'no_of_days',
                'makkah_hotel_period',
                'makkah_hotel_meal_plan',
                'makkah_hotel_category',
                'madinah_hotel_period',
                'madinah_hotel_meal_plan',
                'madinah_hotel_category',
                'azizia_hotel_name',
                'azizia_hotel_period',
                'azizia_hotel_meal_plan',
                'azizia_hotel_distance',
                'azizia_hotel_category',
                'qurbani',
                'airline_ticket',
                'transportation_route',
                'trans_jeddah_makkah',
                'trans_makkah_madinah',
                'trans_madinah_makkah',
                'trans_makkah_jeddah',
                'trans_madinah_madinah',
                'trans_madinah_jeddah',
                'ziarat',
            ]);
        });
    }
};
