<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mechanic_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('specialization_en')->nullable();
            $table->string('specialization_ku')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('workshop_name')->nullable();
            $table->text('workshop_address')->nullable();
            $table->string('workshop_city')->nullable();
            $table->string('workshop_phone')->nullable();
            $table->string('workshop_email')->nullable();
            $table->json('workshop_hours')->nullable();
            $table->json('specialty_tags')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mechanic_details');
    }
};