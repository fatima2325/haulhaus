<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Traits\ProductData;

class shopController extends Controller
{
    use ProductData;

    public function shop()
    {
        // Get all products from database ONLY
        // This ensures that any changes made in the admin panel are immediately reflected on the frontend
        $allProducts = Product::orderBy('category')->orderBy('name')->get()
            ->unique(function ($product) {
                return $product->name . '|' . $product->category;
            });
        
        // Group by category for display
        $groupedProducts = $allProducts->groupBy('category');

        return view('frontend.shop', [
            'groupedProducts' => $groupedProducts
        ]);
    }

    public function productDetail($category, $id)
    {
        // First try to find in database
        $product = Product::where('category', $category)
            ->where('id', $id)
            ->first();

        // If not found in database, check trait (for featured products)
        if (!$product) {
            $allProducts = collect($this->getProducts());
            $productFromTrait = $allProducts->firstWhere('id', $id);
            
            if ($productFromTrait && $productFromTrait['category'] === $category) {
                // Convert trait product to object format
                $product = (object) [
                    'id' => $productFromTrait['id'],
                    'category' => $productFromTrait['category'],
                    'name' => $productFromTrait['name'],
                    'price' => $productFromTrait['price'],
                    'image' => $productFromTrait['image'],
                    'description' => $productFromTrait['description'] ?? null,
                    'reviews' => $productFromTrait['reviews'] ?? [],
                ];
            } else {
                abort(404);
            }
        } else {
            // Convert database product to object format
            $product = (object) [
                'id' => $product->id,
                'category' => $product->category,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'description' => $product->description,
                'reviews' => $product->reviews ?? [],
            ];
        }

        return view('frontend.product', [
            'product' => $product,
            'category' => $category,
            'id' => $id
        ]);
    }
}
