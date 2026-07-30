<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visa_countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_name');
            $table->string('b2b_rate')->nullable();
            $table->string('visa_fee')->nullable();
            $table->text('notes')->nullable();
            $table->string('flag')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('visa_countries');
    }
};
