<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\PseudoTypes\False_;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_email')->nullable();
            $table->string('company_mobileno');
            $table->string('company_phone');
            $table->string('company_address');
            $table->string('company_owner')->nullable();
            $table->longText('company_picture')->nullable();
            $table->longText('company_document')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('logistichub_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
