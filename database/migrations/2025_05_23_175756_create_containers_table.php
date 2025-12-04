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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consolidator_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('container_no');
            $table->string('booking_no');
            $table->string('seal_number');
            $table->string('size');
            $table->string('type');
            $table->bigInteger('total_boxes');
            $table->string('note')->nullable();
            $table->longText('container_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
