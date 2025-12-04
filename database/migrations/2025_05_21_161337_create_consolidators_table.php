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
        Schema::create('consolidators', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('code')->nullable();
            $table->string('address');
            $table->string('mobile_no');
            $table->string('office_no')->nullable();
            $table->boolean('is_download')->default(true);
            $table->boolean('is_upload')->default(true);
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained();
            $table->longText('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->unique();
            $table->longText('company_document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidators');
    }
};
