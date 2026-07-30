<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('full_name');
            $table->string('cnic');
            $table->string('passport_number')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();

            $table->enum('room_type', ['sharing', 'triple', 'double']);

            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_contact')->nullable();

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
    }
};