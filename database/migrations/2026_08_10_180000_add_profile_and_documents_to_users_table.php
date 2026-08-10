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
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('profile_picture');
            }
            if (!Schema::hasColumn('users', 'passport')) {
                $table->string('passport')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'cnic')) {
                $table->string('cnic')->nullable()->after('passport');
            }
            if (!Schema::hasColumn('users', 'visa')) {
                $table->string('visa')->nullable()->after('cnic');
            }
            if (!Schema::hasColumn('users', 'ticket')) {
                $table->string('ticket')->nullable()->after('visa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['profile_picture', 'phone', 'passport', 'cnic', 'visa', 'ticket'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
