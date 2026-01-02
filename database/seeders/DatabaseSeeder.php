<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(AdminSeeder::class);

        // Seed categories first
        $this->call(CategorySeeder::class);

        // Seed products if table is empty
        if (Product::count() === 0) {
            $this->call(ProductSeeder::class);
        }
    }
}
