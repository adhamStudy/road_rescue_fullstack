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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_request_id')->constrained()->onDelete('cascade');

            // Simple Pricing
            $table->decimal('base_price', 8, 2); // Service base price
            $table->decimal('night_tax', 8, 2)->default(0.00); // Night service extra charge
            $table->decimal('total_amount', 8, 2); // Final total

            // Service Info
            $table->boolean('is_night_service')->default(false); // True if service was at night
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
