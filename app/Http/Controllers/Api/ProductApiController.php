<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductApiController extends Controller
{
    /**
     * Get all products
     */
    public function index(): JsonResponse
    {
        $products = Product::with('categoryRelation')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ]);
    }

    /**
     * Get a specific product by ID
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::with(['categoryRelation', 'reviews'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ]);
    }

    /**
     * Create a new product
     */
    public function store(Request $request): JsonResponse
    {
        // Only admin can create
        if ($request->user()->name !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validCategorySlugs = Category::pluck('slug')->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => ['required', 'in:' . implode(',', $validCategorySlugs)],
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|max:255', // Or handle file upload separately in API usually
            'description' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully'
        ], 201);
    }

    /**
     * Update a product
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if ($request->user()->name !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validCategorySlugs = Category::pluck('slug')->toArray();

        $validated = $request->validate([
            'name' => 'string|max:255',
            'category' => ['in:' . implode(',', $validCategorySlugs)],
            'price' => 'numeric|min:0',
            'image' => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Delete a product
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        if ($request->user()->name !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function byCategory(string $category): JsonResponse
    {
        $products = Product::where('category', $category)
            ->with('categoryRelation')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => "Products in category '{$category}' retrieved successfully"
        ]);
    }
}
