<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\PseudoTypes\True_;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('description');
            $table->string('registration_no');
            $table->string('plate_no');
            $table->foreignId('user_id');
            $table->date('date_registered');
            $table->date('date_expired');
            $table->longText('truck_picture')->nullable();
            $table->foreignId('logistichub_id');
            $table->text('Note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
