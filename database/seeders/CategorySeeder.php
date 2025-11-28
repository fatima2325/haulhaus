<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hobo Bags',
                'slug' => 'hobo',
                'description' => 'Stylish and spacious hobo bags perfect for everyday use.',
                'image' => null,
            ],
            [
                'name' => 'Cross Body Bags',
                'slug' => 'cb',
                'description' => 'Convenient cross body bags for hands-free carrying.',
                'image' => null,
            ],
            [
                'name' => 'Backpacks',
                'slug' => 'bp',
                'description' => 'Durable and functional backpacks for all your adventures.',
                'image' => null,
            ],
            [
                'name' => 'Tote Bags',
                'slug' => 'tote',
                'description' => 'Elegant tote bags for work, shopping, and casual outings.',
                'image' => null,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                [
                    'slug' => $categoryData['slug'],
                ],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'image' => $categoryData['image'],
                ]
            );
        }
    }
}
