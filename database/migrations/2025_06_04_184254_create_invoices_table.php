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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id');
            $table->string('invoice');
            $table->string('batchno')->nullable();
            $table->string('sender_name');
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->string('receiver_province');
            $table->string('receiver_city');
            $table->string('receiver_barangay');
            $table->string('receiver_mobile_no');
            $table->string('receiver_home_no')->nullable();
            $table->string('boxtype');
            $table->foreignId('routearea_id')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->boolean('is_assigned')->default(false);
            $table->foreignId('user_id')->nullable();
            $table->string('location_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
