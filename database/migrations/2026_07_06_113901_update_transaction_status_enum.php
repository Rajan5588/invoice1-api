<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE transactions
            MODIFY COLUMN status ENUM('paid','unpaid','overdue')
            NOT NULL DEFAULT 'unpaid'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE transactions
            MODIFY COLUMN status ENUM('paid','pending','failed')
            NOT NULL DEFAULT 'pending'
        ");
    }
};