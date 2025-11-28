@extends('frontend.layouts.main')

@section('main-container')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 mb-4" role="alert" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
            <strong>✓ Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="product-description-page">
        <div class="container">
            <div class="product-detail-card">
                <div class="product-image-section">
                    <img src="{{ asset('frontend/images/' . trim($product->image)) }}"
                         alt="{{ $product->name }}"
                         class="product-image"
                         onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'; this.onerror=null;">
                </div>

                <div class="product-info-section">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <p class="product-price">Rs. {{ number_format($product->price) }}/-</p>

                    <h4>Description</h4>
                    <p class="product-description">
                        {{ $product->description ?? 'No description available.' }}
                    </p>

                    @if(auth()->check() && auth()->user()->name === 'admin')
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Admin users cannot purchase products. Use the admin panel to manage products.
                        </div>
                    @else
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_name" value="{{ $product->name }}">
                            <input type="hidden" name="product_price" value="{{ $product->price }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="product_image" value="{{ $product->image }}">
                            <button type="submit" class="btn btn-success btn-sm">Add To Cart</button>
                        </form>
                    @endif

                    <a href="{{ route('shop') }}" class="btn btn-secondary btn-sm mt-3">Back to Shop</a>
                </div>
            </div>


            {{-- Review Form --}}
            @if(auth()->check() && auth()->user()->name === 'admin')
                <div class="product-reviews mt-5">
                    <p class="text-muted">Admin users cannot submit reviews.</p>
                </div>
            @else
                <div class="product-reviews mt-5">
                    <h4>Write a Review</h4>
                    <div id="review-success-message" class="alert alert-success alert-dismissible fade show mt-3 mb-4" role="alert" style="display: none; background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                        <strong>✓ Success!</strong> <span id="success-text"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div id="review-error-message" class="alert alert-danger alert-dismissible fade show mt-3 mb-4" role="alert" style="display: none;">
                        <span id="error-text"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form id="review-form" action="/product/{{ $category }}/{{ $product->id ?? $id }}/review" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="review_name" class="form-label">Name</label>
                            <input type="text" name="name" id="review_name" class="form-control" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-select" required>
                                <option value="">Select Rating</option>
                                <option value="5">5 ⭐⭐⭐⭐⭐</option>
                                <option value="4">4 ⭐⭐⭐⭐</option>
                                <option value="3">3 ⭐⭐⭐</option>
                                <option value="2">2 ⭐⭐</option>
                                <option value="1">1 ⭐</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Review</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Share your thoughts about this product..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit-review-btn">Submit Review</button>
                    </form>
                </div>
            @endif

            {{-- Display Reviews from Database --}}
            @php
                // Check if product has reviews relationship (database product) or if we need to query
                if (isset($product->reviews) && $product->reviews instanceof \Illuminate\Database\Eloquent\Collection) {
                    $reviews = $product->reviews->sortByDesc('created_at');
                } elseif (isset($product->productReviews) && $product->productReviews instanceof \Illuminate\Database\Eloquent\Collection) {
                    $reviews = $product->productReviews->sortByDesc('created_at');
                } elseif (isset($product->id) && is_numeric($product->id)) {
                    $reviews = \App\Models\Review::where('product_id', $product->id)->orderBy('created_at', 'desc')->get();
                } else {
                    $reviews = collect();
                }
            @endphp

            <div id="reviews-container">
                @if($reviews->count() > 0)
                    <div class="product-reviews mt-5">
                        <h4>Customer Reviews (<span id="review-count">{{ $reviews->count() }}</span>)</h4>
                        <div id="reviews-list">
                            @foreach($reviews as $review)
                                <div class="review-box border rounded p-3 mb-3">
                                    <strong>{{ $review->name }}</strong> — ⭐ {{ $review->rating }}/5
                                    <small class="text-muted d-block">{{ $review->created_at->format('M d, Y') }}</small>
                                    @if($review->comment)
                                        <p class="mb-0 mt-2">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="product-reviews mt-5">
                        <h4>Customer Reviews</h4>
                        <p class="text-muted">No reviews yet for this product. Be the first to review!</p>
                    </div>
                @endif
            </div>


        </div>
    </div>

    <script>
        // Store user name if authenticated
        const userName = {{ auth()->check() && auth()->user() ? json_encode(auth()->user()->name) : "''" }};
        
        document.getElementById('review-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            const form = this;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submit-review-btn');
            const successMsg = document.getElementById('review-success-message');
            const errorMsg = document.getElementById('review-error-message');
            const successText = document.getElementById('success-text');
            const errorText = document.getElementById('error-text');
            
            // Hide previous messages
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            // Submit via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
                }
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        return Promise.reject(data);
                    }
                    return data;
                });
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    successText.textContent = data.message;
                    successMsg.style.display = 'block';
                    
                    // Add new review to the reviews list
                    const reviewsList = document.getElementById('reviews-list');
                    const reviewCount = document.getElementById('review-count');
                    
                    if (reviewsList) {
                        // Create new review element
                        const newReview = document.createElement('div');
                        newReview.className = 'review-box border rounded p-3 mb-3';
                        newReview.innerHTML = `
                            <strong>${data.review.name}</strong> — ⭐ ${data.review.rating}/5
                            <small class="text-muted d-block">${data.review.created_at}</small>
                            ${data.review.comment ? `<p class="mb-0 mt-2">${data.review.comment}</p>` : ''}
                        `;
                        
                        // Insert at the top of the list
                        reviewsList.insertBefore(newReview, reviewsList.firstChild);
                        
                        // Update review count
                        if (reviewCount) {
                            const currentCount = parseInt(reviewCount.textContent) || 0;
                            reviewCount.textContent = currentCount + 1;
                        }
                    } else {
                        // If no reviews list exists, create it
                        const reviewsContainer = document.getElementById('reviews-container');
                        if (reviewsContainer) {
                            reviewsContainer.innerHTML = `
                                <div class="product-reviews mt-5">
                                    <h4>Customer Reviews (<span id="review-count">1</span>)</h4>
                                    <div id="reviews-list">
                                        <div class="review-box border rounded p-3 mb-3">
                                            <strong>${data.review.name}</strong> — ⭐ ${data.review.rating}/5
                                            <small class="text-muted d-block">${data.review.created_at}</small>
                                            ${data.review.comment ? `<p class="mb-0 mt-2">${data.review.comment}</p>` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    }
                    
                    // Reset form
                    form.reset();
                    if (userName && userName !== '') {
                        document.getElementById('review_name').value = userName;
                    }
                    
                    // Scroll to success message
                    successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    // Show error message
                    errorText.textContent = data.message || 'An error occurred. Please try again.';
                    errorMsg.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle error response (could be an object with message or a string)
                const errorMessage = error.message || (typeof error === 'string' ? error : 'An error occurred. Please try again.');
                errorText.textContent = errorMessage;
                errorMsg.style.display = 'block';
                errorMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Review';
            });
        });
    </script>

@endsection
