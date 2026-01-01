<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->unique();
            $table->string('matric_number', 20)->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

    // $table->enum('role', ['user', 'admin'])->default('user');
    // $table->string('username')->unique();
    // $table->date('date_of_birth');
    // $table->string('faculty', 100);
    // $table->string('department', 100);
    // $table->enum('level', [100, 200, 300, 400, 500]);