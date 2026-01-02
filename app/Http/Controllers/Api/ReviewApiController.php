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

    /**
     * Store a new review
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Prevent admin from submitting reviews
        if (auth()->check() && auth()->user()->name === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Admin users cannot submit reviews.'
            ], 403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // If logged in, allow updating the existing review instead of blocking
        $existingReview = null;
        if (auth()->check()) {
            $existingReview = Review::where('product_id', $validated['product_id'])
                ->where('user_id', auth()->id())
                ->first();
        }

        $imageName = $existingReview ? $existingReview->image : null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = \Illuminate\Support\Str::slug($baseName) ?: 'review-image';
            $extension = $file->getClientOriginalExtension();
            $imageName = $safeName . '-' . time() . '.' . $extension;

            $destination = public_path('frontend/reviews');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $imageName);
        }

        if ($existingReview) {
            $existingReview->update([
                'name' => $validated['name'],
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'image' => $imageName,
            ]);
            $review = $existingReview;
        } else {
            $review = Review::create([
                'product_id' => $validated['product_id'],
                'user_id' => auth()->check() ? auth()->id() : null,
                'name' => $validated['name'],
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'image' => $imageName,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $existingReview ? 'Review updated successfully' : 'Review submitted successfully',
            'data' => $review
        ], 201);
    }
}


