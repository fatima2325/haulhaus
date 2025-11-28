<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product.
     */
    public function store(Request $request, $category, $id)
    {
        // Prevent admin from submitting reviews
        if (auth()->check() && auth()->user()->name === 'admin') {
            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin users cannot submit reviews.'
                ], 403);
            }
            // Fallback for non-AJAX
            return redirect()->to("/product/{$category}/{$id}")
                ->with('error', 'Admin users cannot submit reviews.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Find the product by ID (IDs are unique, so we don't need category check)
        $product = Product::find($id);
            
        if (!$product) {
            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found. Please refresh the page and try again.'
                ], 404);
            }
            // Fallback for non-AJAX
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Check if authenticated user has already reviewed this product (only for logged-in users)
        if (auth()->check()) {
            $existingReview = Review::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingReview) {
                // Return JSON for AJAX requests
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already reviewed this product. You can edit your review by submitting a new one.'
                    ], 422);
                }
                // Fallback for non-AJAX
                return redirect()->to("/product/{$category}/{$id}")
                    ->withInput()
                    ->with('error', 'You have already reviewed this product. You can edit your review by submitting a new one.');
            }
        }

        // Create the review (user_id can be null for guest reviews)
        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // Return JSON response for AJAX requests (no redirect)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! Your review has been submitted successfully.',
                'review' => [
                    'name' => $validated['name'],
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'] ?? '',
                    'created_at' => now()->format('M d, Y'),
                ]
            ]);
        }
        
        // Fallback for non-AJAX requests - stay on product page
        return redirect()->to("/product/{$category}/{$id}")
            ->with('success', 'Thank you for your review! Your review has been submitted successfully.');
    }
}
