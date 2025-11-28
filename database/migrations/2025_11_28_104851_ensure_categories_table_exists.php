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
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->timestamps();
            });
        } else {
            // If table exists but is missing columns, add them
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('categories', 'slug')) {
                    $table->string('slug')->unique()->after('name');
                }
                if (!Schema::hasColumn('categories', 'description')) {
                    $table->text('description')->nullable()->after('slug');
                }
                if (!Schema::hasColumn('categories', 'image')) {
                    $table->string('image')->nullable()->after('description');
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
