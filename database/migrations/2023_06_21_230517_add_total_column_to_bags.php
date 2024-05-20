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
        Schema::table('bags', function (Blueprint $table) {
            if (!Schema::hasColumn('bags', 'total')) {
                // Add the 'total' column to the 'bags' table
                Schema::table('bags', function (Blueprint $table) {
                    $table->double('total', 8, 2)->default(0)->after('per_bag_price');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bags', function (Blueprint $table) {
           // Check if the 'total' column exists
            if (Schema::hasColumn('bags', 'total')) {
                // Remove the 'total' column from the 'bags' table
                Schema::table('bags', function (Blueprint $table) {
                    $table->dropColumn('total');
                });
            }
        });
    }
};
