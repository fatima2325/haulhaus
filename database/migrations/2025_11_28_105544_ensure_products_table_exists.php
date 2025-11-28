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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category'); // hobo, cb, bp, tote
                $table->decimal('price', 10, 2);
                $table->string('image');
                $table->text('description')->nullable();
                $table->json('reviews')->nullable(); // Store reviews as JSON
                $table->timestamps();
            });
        } else {
            // If table exists but is missing columns, add them
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('products', 'category')) {
                    $table->string('category')->after('name');
                }
                if (!Schema::hasColumn('products', 'price')) {
                    $table->decimal('price', 10, 2)->after('category');
                }
                if (!Schema::hasColumn('products', 'image')) {
                    $table->string('image')->after('price');
                }
                if (!Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable()->after('image');
                }
                if (!Schema::hasColumn('products', 'reviews')) {
                    $table->json('reviews')->nullable()->after('description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to preserve data
    }
};
