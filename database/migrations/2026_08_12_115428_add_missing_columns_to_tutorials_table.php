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
        Schema::table('tutorials', function (Blueprint $table) {
            if (!Schema::hasColumn('tutorials', 'video_file')) {
                $table->string('video_file')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('tutorials', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('video_file');
            }
            if (!Schema::hasColumn('tutorials', 'category')) {
                $table->string('category')->nullable()->after('thumbnail');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutorials', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'thumbnail', 'category']);
        });
    }
};
