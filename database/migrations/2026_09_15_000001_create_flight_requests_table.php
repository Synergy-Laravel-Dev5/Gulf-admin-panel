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
        Schema::create('flight_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('guest_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('trip_type', ['one_way', 'return', 'multi_city'])->default('one_way');
            $table->string('leaving_from');
            $table->string('going_to');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('infants')->default(0);
            $table->string('cabin_class')->default('economy');
            $table->json('multi_city_legs')->nullable();
            $table->text('notes')->nullable();
            $table->string('passport_document')->nullable();
            $table->string('documents_upload')->nullable();
            $table->enum('status', ['pending', 'processing', 'approved', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_requests');
    }
};
