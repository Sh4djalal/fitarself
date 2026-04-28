<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('trim')->nullable();
            $table->string('engine_type')->nullable();
            $table->integer('horsepower')->nullable();
            $table->decimal('zero_to_100_kmh', 5, 2)->nullable();
            $table->integer('top_speed_kmh')->nullable();
            $table->enum('transmission', ['manual', 'automatic', 'cvt', 'dct'])->nullable();
            $table->integer('gears')->nullable();
            $table->string('drivetrain')->nullable();
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric'])->nullable();
            $table->enum('body_type', ['sedan', 'suv', 'hatchback', 'coupe', 'truck', 'van', 'wagon'])->nullable();
            $table->decimal('oil_capacity_l', 5, 2)->nullable();
            $table->string('oil_density_type')->nullable();
            $table->decimal('hydraulic_capacity_l', 5, 2)->nullable();
            $table->string('hydraulic_fluid_type')->nullable();
            $table->decimal('fuel_combined_l_100km', 5, 2)->nullable();
            $table->decimal('fuel_city_l_100km', 5, 2)->nullable();
            $table->decimal('fuel_highway_l_100km', 5, 2)->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ku')->nullable();
            $table->string('image_path')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('review_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};