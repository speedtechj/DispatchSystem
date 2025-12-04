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
        Schema::create('logistichubs', function (Blueprint $table) {
            $table->id();
            $table->string('hub_code');
            $table->string('hub_name');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_company')->default(false);
            $table->bigInteger('trip_counter')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_assigned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistichubs');
    }
};
