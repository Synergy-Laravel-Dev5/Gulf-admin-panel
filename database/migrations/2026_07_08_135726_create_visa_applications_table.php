<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visa_applications', function (Blueprint $table) {

            $table->id();


            $table->foreignId('visa_type_id')
                ->constrained('visa_types')
                ->cascadeOnDelete();


            $table->string('full_name');

            $table->string('phone');

            $table->string('email')
                ->nullable();

            $table->string('cnic')
                ->nullable();


            $table->string('passport_scan')
                ->nullable();

            $table->string('picture')
                ->nullable();

            $table->string('cnic_front')
                ->nullable();

            $table->string('cnic_back')
                ->nullable();

            $table->string('bank_statement')
                ->nullable();

            $table->string('other_document')
                ->nullable();


            $table->string('status')
                ->default('pending');

            $table->text('remarks')
                ->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visa_applications');
    }
};
