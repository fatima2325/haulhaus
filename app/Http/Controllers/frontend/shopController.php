<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class shopController extends Controller
{
    public function shop()
    {
        $categoryLabels = [
            'tote' => 'Tote Bags',
            'bp' => 'Backpacks',
            'cb' => 'Cross Body Bags',
            'hobo' => 'Hobo Bags',
        ];

        // Get all products from database ONLY
        // This ensures that any changes made in the admin panel are immediately reflected on the frontend
        $allProducts = Product::with('categoryRelation')->orderBy('category')->orderBy('name')->get()
            ->unique(function ($product) {
                return $product->name . '|' . $product->category;
            });

        // Group by category for display
        $groupedProducts = $allProducts->groupBy('category');

        // Fetch all categories to show empty states when no products exist
        $categories = Category::orderBy('name')->get();

        // Build a keyed list to include empty categories
        $categoriesWithProducts = $categories->mapWithKeys(function ($category) use ($groupedProducts) {
            return [
                $category->slug => [
                    'category' => $category,
                    'products' => $groupedProducts->get($category->slug, collect())
                ]
            ];
        });

        return view('frontend.shop', [
            'groupedProducts' => $groupedProducts,
            'categoriesWithProducts' => $categoriesWithProducts,
            'categoryLabels' => $categoryLabels,
        ]);
    }

    /**
     * Ajax search for products by name or category (frontend).
     */
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $categoryLabels = [
            'tote' => 'Tote Bags',
            'bp' => 'Backpacks',
            'cb' => 'Cross Body Bags',
            'hobo' => 'Hobo Bags',
        ];

        // Fetch a reasonable set, then filter client-style for prefix/substring matches
        $products = Product::orderBy('name')->limit(200)->get();

        if ($query !== '') {
            $q = mb_strtolower($query);
            $products = $products->filter(function ($product) use ($q, $categoryLabels) {
                $name = mb_strtolower($product->name ?? '');
                $categoryLabel = mb_strtolower($categoryLabels[$product->category] ?? $product->category ?? '');
                $categorySlug = mb_strtolower($product->category ?? '');

                $matchesNamePrefix = str_starts_with($name, $q);
                $matchesCategoryPrefix = str_starts_with($categoryLabel, $q);
                $matchesSlugPrefix = str_starts_with($categorySlug, $q);

                // Allow infix matches as a fallback if prefix doesn't catch
                $matchesNameContains = $matchesNamePrefix ? true : str_contains($name, $q);
                $matchesCategoryContains = $matchesCategoryPrefix ? true : str_contains($categoryLabel, $q);
                $matchesSlugContains = $matchesSlugPrefix ? true : str_contains($categorySlug, $q);

                return $matchesNamePrefix || $matchesCategoryPrefix || $matchesSlugPrefix
                    || $matchesNameContains || $matchesCategoryContains || $matchesSlugContains;
            });
        }

        // Alphabetical sorting for results
        $products = $products->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values();

        $categories = Category::pluck('name', 'slug');

        $results = $products->map(function ($product) use ($categories, $categoryLabels) {
            $categoryName = $categories[$product->category] ?? $categoryLabels[$product->category] ?? ucfirst($product->category);
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $categoryName,
                'price' => $product->price,
                'image' => asset('frontend/images/' . trim($product->image)),
                'url' => route('product.detail', [$product->category, $product->id]),
            ];
        });

        return response()->json(['data' => $results]);
    }

    public function productDetail($category, $id)
    {
        // Get product from database only (no trait fallback)
        $product = Product::where('id', $id)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        // Load reviews from database
        $product->load([
            'reviews' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);

        return view('frontend.product', [
            'product' => $product,
            'category' => $category,
            'id' => $id
        ]);
    }
}
