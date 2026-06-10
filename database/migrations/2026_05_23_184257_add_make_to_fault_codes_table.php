<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fault_codes', function (Blueprint $table) {
            $table->string('make')->default('All')->after('code_type');
        });
    }

    public function down(): void
    {
        Schema::table('fault_codes', function (Blueprint $table) {
            $table->dropColumn('make');
        });
    }
};