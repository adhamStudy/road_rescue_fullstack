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
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password');

            // Location & Status
            $table->double('current_lat')->nullable();
            $table->double('current_lng')->nullable();
            $table->boolean('is_available')->default(true);
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Simple Rating
            $table->decimal('rating', 3, 2)->default(0.00); // e.g. 4.85 out of 5

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
