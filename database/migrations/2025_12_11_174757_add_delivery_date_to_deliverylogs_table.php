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
        Schema::table('deliverylogs', function (Blueprint $table) {
            $table->date('delivery_date')->nullable()->after('departure_date');
            $table->string('waybill_number')->nullable()->after('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliverylogs', function (Blueprint $table) {
            $table->dropColumn('delivery_date');
            $table->dropColumn('waybill_number');
        });
    }
};
