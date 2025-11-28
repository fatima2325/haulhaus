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
        // Create orders table if it doesn't exist (must be created first before order_items)
        if (!Schema::hasTable('orders')) {
            try {
                Schema::create('orders', function (Blueprint $table) {
                    $table->id();
                    $table->string('order_number')->unique();
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                    $table->string('name');
                    $table->string('email');
                    $table->text('address');
                    $table->string('payment_method');
                    $table->decimal('total_amount', 10, 2);
                    $table->string('status')->default('pending');
                    $table->timestamps();
                });
            } catch (\Exception $e) {
                // Table might have been created between check and creation
                if (!Schema::hasTable('orders')) {
                    throw $e;
                }
            }
        } else {
            // Add missing columns if table exists but columns are missing
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'order_number')) {
                    $table->string('order_number')->unique()->after('id');
                }
                if (!Schema::hasColumn('orders', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->after('order_number');
                }
                if (!Schema::hasColumn('orders', 'name')) {
                    $table->string('name')->after('user_id');
                }
                if (!Schema::hasColumn('orders', 'email')) {
                    $table->string('email')->after('name');
                }
                if (!Schema::hasColumn('orders', 'address')) {
                    $table->text('address')->after('email');
                }
                if (!Schema::hasColumn('orders', 'payment_method')) {
                    $table->string('payment_method')->after('address');
                }
                if (!Schema::hasColumn('orders', 'total_amount')) {
                    $table->decimal('total_amount', 10, 2)->after('payment_method');
                }
                if (!Schema::hasColumn('orders', 'status')) {
                    $table->string('status')->default('pending')->after('total_amount');
                }
            });
        }

        // Create order_items table if it doesn't exist
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
                $table->string('product_name');
                $table->decimal('product_price', 10, 2);
                $table->integer('quantity');
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();
            });
        } else {
            // Add missing columns if table exists but columns are missing
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'order_id')) {
                    $table->foreignId('order_id')->constrained()->onDelete('cascade')->after('id');
                }
                if (!Schema::hasColumn('order_items', 'product_id')) {
                    $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null')->after('order_id');
                }
                if (!Schema::hasColumn('order_items', 'product_name')) {
                    $table->string('product_name')->after('product_id');
                }
                if (!Schema::hasColumn('order_items', 'product_price')) {
                    $table->decimal('product_price', 10, 2)->after('product_name');
                }
                if (!Schema::hasColumn('order_items', 'quantity')) {
                    $table->integer('quantity')->after('product_price');
                }
                if (!Schema::hasColumn('order_items', 'subtotal')) {
                    $table->decimal('subtotal', 10, 2)->after('quantity');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop tables in down() to preserve data
        // Schema::dropIfExists('order_items');
        // Schema::dropIfExists('orders');
    }
};
