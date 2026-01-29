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
            $table->foreignId('deliveryloghub_id')->nullable()->constrained('deliverylogs','id');
            $table->boolean('is_loaded_hub')->default(false);
            $table->boolean('hub_assigned')->default(false);
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tripinvoices', function (Blueprint $table) {
            $table->dropColumn('is_loaded_hub');
            $table->dropColumn('deliveryloghub_id');
            $table->dropColumn('hub_assigned');
        });
    }
};
