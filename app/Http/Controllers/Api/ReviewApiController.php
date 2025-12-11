<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    /**
     * Get all reviews
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $reviews = Review::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $reviews,
            'message' => 'Reviews retrieved successfully'
        ]);
    }

    /**
     * Get reviews for a specific product
     * 
     * @param int $productId
     * @return JsonResponse
     */
    public function byProduct(int $productId): JsonResponse
    {
        $reviews = Review::with(['product', 'user'])
            ->where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $reviews,
            'message' => 'Product reviews retrieved successfully'
        ]);
    }

    /**
     * Get a specific review by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $review = Review::with(['product', 'user'])->find($id);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review retrieved successfully'
        ]);
    }
}


