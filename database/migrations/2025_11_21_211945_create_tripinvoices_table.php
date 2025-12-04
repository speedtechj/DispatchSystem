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
        Schema::create('tripinvoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->foreignId('deliverylog_id')->constrained();
            $table->foreignId('invoice_id')->constrained();
            $table->boolean('is_loaded')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->foreignId('logistichub_id');
            $table->longText('delivery_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tripinvoices');
    }
};
