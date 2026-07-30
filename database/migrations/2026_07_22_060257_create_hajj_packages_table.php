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
        Schema::create('hajj_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('makkah_hotel_name')->nullable();
            $table->string('makkah_hotel_distance')->nullable();
            $table->string('madinah_hotel_name')->nullable();
            $table->string('madinah_hotel_distance')->nullable();
            $table->date('travel_date_from')->nullable();
            $table->date('travel_date_to')->nullable();
            $table->decimal('price_sharing', 10, 2)->nullable();
            $table->decimal('price_triple', 10, 2)->nullable();
            $table->decimal('price_double', 10, 2)->nullable();
            $table->text('features')->nullable();
            $table->text('requirements')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hajj_packages');
    }
};
