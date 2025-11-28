<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Traits\ProductData;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use ProductData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = $this->getProducts();

        foreach ($products as $productData) {
            // Use updateOrCreate to prevent duplicates based on name and category
            Product::updateOrCreate(
                [
                    'name' => $productData['name'],
                    'category' => $productData['category'],
                ],
                [
                    'price' => $productData['price'],
                    'image' => $productData['image'],
                    'description' => $productData['description'] ?? null,
                    'reviews' => $productData['reviews'] ?? null,
                ]
            );
        }
    }
}

