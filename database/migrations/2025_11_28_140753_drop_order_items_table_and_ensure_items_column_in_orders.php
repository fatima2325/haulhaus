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
        // Drop order_items table if it exists
        if (Schema::hasTable('order_items')) {
            // Drop foreign key constraints first
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                Schema::dropIfExists('order_items');
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (\Exception $e) {
                // If foreign key drop fails, try without it
                Schema::dropIfExists('order_items');
            }
        }

        // Ensure items column exists in orders table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'items')) {
                    $table->json('items')->nullable()->after('total_amount');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove items column from orders table
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'items')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('items');
            });
        }

        // Note: We don't recreate order_items table in down() as it's being removed permanently
    }
};
