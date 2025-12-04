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
        Schema::create('truckcrews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->unique()->constrained();
            $table->foreignId('driver')->constrained('users','id');
            $table->foreignId('leadman')->constrained('users','id');
            $table->foreignId('Porter')->constrained('users','id');
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truckcrews');
    }
};
