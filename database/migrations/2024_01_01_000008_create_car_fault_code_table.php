<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_fault_code', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fault_code_id')->constrained()->cascadeOnDelete();
            $table->text('notes_en')->nullable();
            $table->text('notes_ku')->nullable();
            $table->timestamps();
            $table->unique(['car_id', 'fault_code_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_fault_code');
    }
};