<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->unsignedBigInteger('owner_id');
            $table->string('company_code'); // just store the company code
            $table->timestamps();

            // Only owner_id as foreign key
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
