<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_profiles', function (Blueprint $table) {

            $table->string('business_name')->nullable()->after('business_id');

            $table->string('business_type')->nullable()->after('business_category');

        });
    }

    public function down(): void
    {
        Schema::table('business_profiles', function (Blueprint $table) {

            $table->dropColumn([
                'business_name',
                'business_type'
            ]);

        });
    }
};