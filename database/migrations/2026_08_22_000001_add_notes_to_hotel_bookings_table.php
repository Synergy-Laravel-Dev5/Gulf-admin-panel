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
        Schema::table('hotel_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('hotel_bookings', 'notes')) {
                $table->text('notes')->nullable()->after('meal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('hotel_bookings', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};
