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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'cnic_front')) {
                $table->string('cnic_front')->nullable()->after('cnic');
            }
            if (!Schema::hasColumn('users', 'cnic_back')) {
                $table->string('cnic_back')->nullable()->after('cnic_front');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'cnic_front')) {
                $table->dropColumn('cnic_front');
            }
            if (Schema::hasColumn('users', 'cnic_back')) {
                $table->dropColumn('cnic_back');
            }
        });
    }
};
