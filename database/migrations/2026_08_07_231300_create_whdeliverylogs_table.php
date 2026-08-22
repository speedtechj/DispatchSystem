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
        Schema::create('whdeliverylogs', function (Blueprint $table) {
            $table->id();
            $table->string('trip_number');
            $table->foreignId('truck_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->date('departure_date');
            $table->date('delivery_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_lock')->default(false);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whdeliverylogs');
    }
};
