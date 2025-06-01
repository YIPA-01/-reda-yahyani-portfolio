<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('education', function (Blueprint $table) {
            // Add new columns
            $table->date('start_date')->nullable()->after('field');
            $table->date('end_date')->nullable()->after('start_date');
            $table->text('description')->nullable()->after('end_date');
        });

        // Copy data from old columns to new ones
        DB::statement("UPDATE education SET start_date = CONCAT(start_year, '-01-01')");
        DB::statement("UPDATE education SET end_date = CONCAT(end_year, '-01-01')");

        Schema::table('education', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['start_year', 'end_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education', function (Blueprint $table) {
            // Add old columns back
            $table->integer('start_year')->nullable()->after('field');
            $table->integer('end_year')->nullable()->after('start_year');
        });

        // Copy data back to old columns
        DB::statement("UPDATE education SET start_year = YEAR(start_date)");
        DB::statement("UPDATE education SET end_year = YEAR(end_date)");

        Schema::table('education', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['start_date', 'end_date', 'description']);
        });
    }
};
