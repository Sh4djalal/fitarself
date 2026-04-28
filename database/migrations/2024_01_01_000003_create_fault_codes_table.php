<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fault_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->char('code_type', 1);
            $table->string('title_en');
            $table->string('title_ku');
            $table->text('description_en');
            $table->text('description_ku');
            $table->text('symptoms_en')->nullable();
            $table->text('symptoms_ku')->nullable();
            $table->text('possible_causes_en')->nullable();
            $table->text('possible_causes_ku')->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('system')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fault_codes');
    }
};