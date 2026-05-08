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
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('is_priority')->default(false)->after('location_code');
            $table->string('problem_description')->nullable()->after('is_priority');
            $table->text('remark')->nullable()->after('problem_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('is_priority');
            $table->dropColumn('problem_description');
            $table->dropColumn('remark');
        });
    }
};
