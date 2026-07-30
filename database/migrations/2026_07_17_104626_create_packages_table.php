<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hajj', 'umrah']);
            $table->string('title');
            $table->string('subtitle')->nullable();

            $table->string('makkah_hotel_name')->nullable();
            $table->string('makkah_hotel_distance')->nullable();
            $table->string('madinah_hotel_name')->nullable();
            $table->string('madinah_hotel_distance')->nullable();

            $table->date('travel_date_from')->nullable();
            $table->date('travel_date_to')->nullable();

            $table->decimal('price_sharing', 12, 2)->nullable();
            $table->decimal('price_triple', 12, 2)->nullable();
            $table->decimal('price_double', 12, 2)->nullable();

            $table->text('features')->nullable();      // key features (comma/newline separated)
            $table->text('requirements')->nullable();  // documents required
            $table->text('description')->nullable();

            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
