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
        Schema::create('companyprofiles', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->longText('company_logo')->nullable();
            $table->string('company_address');
            $table->string('company_barangay');
            $table->string('company_city');
            $table->string('company_province');
             $table->string('company_zipcode');
            $table->string('company_email');
            $table->string('company_mobile_no');
            $table->string('company_office_no');
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companyprofiles');
    }
};
