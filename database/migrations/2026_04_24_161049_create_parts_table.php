<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ku');
            $table->text('description_en')->nullable();
            $table->text('description_ku')->nullable();
            $table->string('category'); // engine, brakes, suspension, electrical, body, oil
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('IQD');
            $table->string('image_path')->nullable();
            $table->string('brand')->nullable();
            $table->string('part_number')->nullable();
            $table->json('compatible_cars')->nullable(); // ["Toyota Camry 2020-2024", "Toyota Corolla 2019-2024"]
            $table->boolean('in_stock')->default(true);
            $table->integer('stock_quantity')->default(0);
            $table->string('condition')->default('new'); // new, used, refurbished
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};