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
        Schema::create('unmanifesteds', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->nullable();
            $table->foreignId('container_id')->constrained();
            $table->text('remarks')->nullable();
            $table->longText('attachment_pic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unmanifesteds');
    }
};
