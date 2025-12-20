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
        Schema::table('containers', function (Blueprint $table) {
            //
            $table->string('batch_no')->nullable()->after('booking_no');
            $table->year('batch_year')->nullable()->after('Batch_no');
            $table->boolean('is_unloaded')->default(false)->after('batch_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('containers', function (Blueprint $table) {
            //
            $table->dropColumn('Batch_no');
            $table->dropColumn('batch_year');
            $table->dropColumn('is_unloaded');
        });
    }
};
