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
        Schema::create('deliverylogs', function (Blueprint $table) {
            $table->id();
            $table->string('trip_number')->unique();
            $table->foreignId('truck_id')->nullable()->constrained();
            $table->bigInteger('trip_day');
            $table->foreignId('logistichub_id');
            $table->date('eta');
            $table->date('departure_date');
            $table->foreignId('assigned_to')->constrained('logistichubs','id');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliverylogs');
    }
};
