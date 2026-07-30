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
        Schema::create('visa_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visa_country_id')
                ->constrained('visa_countries')
                ->cascadeOnDelete();
            $table->string('visa_name');
            $table->string('b2b_rate')->nullable();
            $table->string('visa_fee')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_types');
    }
};
