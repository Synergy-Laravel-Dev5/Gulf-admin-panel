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
        Schema::create('domestic_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('departure_city')->nullable();
            $table->string('destination_city');
            $table->string('hotel_name')->nullable();
            $table->string('hotel_rating')->nullable(); // e.g. 3 star, 4 star
            $table->integer('duration_days')->nullable();
            $table->date('travel_date_from')->nullable();
            $table->date('travel_date_to')->nullable();
            $table->decimal('price_per_person', 10, 2)->nullable();
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
        Schema::dropIfExists('domestic_packages');
    }
};
