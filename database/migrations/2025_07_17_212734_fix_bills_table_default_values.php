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
        Schema::table('bills', function (Blueprint $table) {
            // Modify total_amount to have a default value
            $table->decimal('total_amount', 8, 2)->default(0.00)->change();

            // Also add notes field for additional information
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('total_amount', 8, 2)->change();
            $table->dropColumn('notes');
        });
    }
};
