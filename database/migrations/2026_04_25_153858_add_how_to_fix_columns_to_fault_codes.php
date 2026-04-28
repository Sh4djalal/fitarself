<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('fault_codes', 'how_to_fix_en')) {
            Schema::table('fault_codes', function (Blueprint $table) {
                $table->text('how_to_fix_en')->nullable();
                $table->text('how_to_fix_ku')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('fault_codes', function (Blueprint $table) {
            if (Schema::hasColumn('fault_codes', 'how_to_fix_en')) {
                $table->dropColumn(['how_to_fix_en', 'how_to_fix_ku']);
            }
        });
    }
};