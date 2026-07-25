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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nickname')->nullable();
            $table->string('street');
            $table->string('number');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('complement')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rent_value', 10, 2)->nullable();
            $table->string('status')->default('available');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('property_type_id');
            $table->foreign('property_type_id')->references('id')->on('property_types')->restrictOnDelete();

            $table->unsignedBigInteger('configuration_id')->after('id');
            $table->foreign('configuration_id')->references('id')->on('configurations')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
