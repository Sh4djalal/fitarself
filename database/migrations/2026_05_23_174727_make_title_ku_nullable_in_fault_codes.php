<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fault_codes', function (Blueprint $table) {
            $table->string('title_ku')->nullable()->change();
            $table->text('description_ku')->nullable()->change();
            $table->text('symptoms_ku')->nullable()->change();
            $table->text('possible_causes_ku')->nullable()->change();
            $table->text('how_to_fix_ku')->nullable()->change();
        });
    }

    public function down(): void
    {
        //
    }
};