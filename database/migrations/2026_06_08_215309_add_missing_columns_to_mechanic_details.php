<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mechanic_details', function (Blueprint $table) {
            if (!Schema::hasColumn('mechanic_details', 'workshop_name')) {
                $table->string('workshop_name')->nullable();
            }
            if (!Schema::hasColumn('mechanic_details', 'shop_phone')) {
                $table->string('shop_phone')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('mechanic_details', function (Blueprint $table) {
            $table->dropColumn(['workshop_name', 'shop_phone']);
        });
    }
};