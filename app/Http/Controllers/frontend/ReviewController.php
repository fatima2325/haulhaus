<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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

        // If logged in, allow updating the existing review instead of blocking
        $existingReview = null;
        if (auth()->check()) {
            $existingReview = Review::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        $imageName = $existingReview->image ?? null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = Str::slug($baseName) ?: 'review-image';
            $extension = $file->getClientOriginalExtension();
            $imageName = $safeName . '-' . time() . '.' . $extension;

            $destination = public_path('frontend/reviews');
            File::ensureDirectoryExists($destination);
            $file->move($destination, $imageName);
        }

        // Create or update the review (user_id can be null for guest reviews)
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
                'product_id' => $product->id,
                'user_id' => auth()->check() ? auth()->id() : null,
                'name' => $validated['name'],
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'image' => $imageName,
            ]);
        }

        // Return JSON response for AJAX requests (no redirect)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $existingReview ? 'Your review has been updated.' : 'Thank you for your review! Your review has been submitted successfully.',
                'review' => [
                    'name' => $review->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment ?? '',
                    'created_at' => $review->created_at->format('M d, Y'),
                    'image_url' => $review->image ? asset('frontend/reviews/' . $review->image) : null,
                ]
            ]);
        }
        
        // Fallback for non-AJAX requests - stay on product page
        return redirect()->to("/product/{$category}/{$id}")
            ->with('success', $existingReview ? 'Your review has been updated.' : 'Thank you for your review! Your review has been submitted successfully.');
    }
}
