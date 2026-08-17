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
        Schema::table('umrah_packages', function (Blueprint $table) {
            $table->json('durations')->nullable()->after('price_double');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umrah_packages', function (Blueprint $table) {
            $table->dropColumn('durations');
        });
    }
};
