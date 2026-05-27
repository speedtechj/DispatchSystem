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
        Schema::table('tripinvoices', function (Blueprint $table) {
              // ✅ Missing FK index — most critical
            $table->index('logistichub_id', 'idx_logistichub_id');

            // ✅ Delivery status filter
            $table->index(['is_loaded', 'is_delivered'], 'idx_is_loaded_delivered');

            // ✅ Hub status filter
            $table->index(['hub_assigned', 'is_loaded_hub'], 'idx_hub_assigned_loaded_hub');

            // ✅ Date range / sorting queries
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tripinvoices', function (Blueprint $table) {
            $table->dropIndex('idx_logistichub_id');
            $table->dropIndex('idx_is_loaded_delivered');
            $table->dropIndex('idx_hub_assigned_loaded_hub');
            $table->dropIndex('idx_created_at');
        });
    }
};
