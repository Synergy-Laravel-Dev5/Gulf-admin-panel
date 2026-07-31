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
        Schema::table('package_bookings', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
        });

        Schema::table('package_bookings', function (Blueprint $table) {
            $table->string('package_type')->nullable()->after('package_id')->default('hajj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_bookings', function (Blueprint $table) {
            $table->dropColumn('package_type');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }
};
