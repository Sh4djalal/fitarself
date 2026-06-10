<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp', 6);
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamps();
        });
        
        // Add verified_at column to users table if not exists
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('email_verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verified_at');
        });
    }
};