<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('email');
            $table->string('fcm_token')->nullable()->after('phone');
            $table->boolean('otp_verified')->default(false)->after('fcm_token');
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->text('full_address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'fcm_token',
                'otp_verified',
                'state',
                'district',
                'full_address',
            ]);
        });
    }
};