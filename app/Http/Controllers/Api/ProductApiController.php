<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    /**
     * Get all products
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::with('reviews')->orderBy('name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ]);
    }

    /**
     * Get a specific product by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::with('reviews')->find($id);
        
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
     * Get products by category
     * 
     * @param string $category
     * @return JsonResponse
     */
    public function byCategory(string $category): JsonResponse
    {
        $products = Product::with('reviews')
            ->where('category', $category)
            ->orderBy('name')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => "Products in category '{$category}' retrieved successfully"
        ]);
    }
}


