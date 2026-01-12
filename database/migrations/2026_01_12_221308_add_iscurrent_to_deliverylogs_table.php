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
        Schema::table('deliverylogs', function (Blueprint $table) {
            $table->boolean('is_current')->default(false)->after('assigned_to');
            $table->boolean('is_active')->default(true)->after('is_current');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliverylogs', function (Blueprint $table) {
            $table->dropColumn('is_current');
            $table->dropColumn('is_active');
        });
    }
};
