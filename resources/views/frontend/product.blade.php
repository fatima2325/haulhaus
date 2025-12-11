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
                <div class="product-image-section text-center">
                    <img src="{{ asset('frontend/images/' . trim($product->image)) }}"
                         alt="{{ $product->name }}"
                         class="product-image"
                         style="max-width: 360px; width: 100%; height: auto;"
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
                    <form id="review-form" action="/product/{{ $category }}/{{ $product->id ?? $id }}/review" method="POST" class="mb-4" enctype="multipart/form-data">
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
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload an image (optional)</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/png,image/jpeg,image/webp">
                            <small class="text-muted">Accepted: JPG, PNG, WEBP. Max size: 2MB.</small>
                            <div class="mt-3" id="image-preview-container" style="display:none;">
                                <label class="form-label fw-semibold" style="color: #430a1e; font-size: 16px;">📷 Image Preview:</label>
                                <div class="border rounded p-3 bg-light mt-2" style="display: block; border: 2px solid #430a1e !important; background-color: #f8f9fa !important;">
                                    <div class="text-center mb-2">
                                        <small class="text-muted" id="image-filename"></small>
                                    </div>
                                    <img id="image-preview" src="" alt="Preview" style="max-width: 400px; max-height: 400px; width: auto; height: auto; display: block; margin: 0 auto; border: 1px solid #ddd;" class="rounded shadow-sm">
                                </div>
                            </div>
                            <p id="image-error" class="text-danger mt-2" style="display:none;"></p>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit-review-btn">Submit Review</button>
                    </form>
                </div>
            @endif

            {{-- Display Reviews from Database --}}
            @php
                // Always pull reviews from the reviews table (ignore any legacy JSON on products)
                $reviews = \App\Models\Review::where('product_id', $product->id ?? 0)
                    ->orderBy('created_at', 'desc')
                    ->get();
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
                                    @if($review->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('frontend/reviews/' . $review->image) }}" alt="Review image" style="max-height: 100px;" class="rounded border">
                                        </div>
                                    @endif
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
        // Image preview handler for review form - shows both filename and image preview
        (function() {
            function initImagePreview() {
                const imageInput = document.getElementById('image');
                const imagePreview = document.getElementById('image-preview');
                const imagePreviewContainer = document.getElementById('image-preview-container');
                const imageFilename = document.getElementById('image-filename');
                const imageError = document.getElementById('image-error');
                
                if (!imageInput) {
                    console.log('Image input not found, retrying...');
                    setTimeout(initImagePreview, 100);
                    return;
                }
                
                if (!imagePreview || !imagePreviewContainer) {
                    console.log('Preview elements not found, retrying...');
                    setTimeout(initImagePreview, 100);
                    return;
                }
                
                console.log('Image preview handler initialized');
                
                // Function to display image preview with filename
                function displayPreview(file) {
                    console.log('Displaying preview for file:', file.name);
                    
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        if (imageError) {
                            imageError.textContent = 'Unsupported image type. Please use JPG, PNG, or WEBP.';
                            imageError.style.display = 'block';
                        }
                        imageInput.value = '';
                        imagePreviewContainer.style.display = 'none';
                        if (imagePreview) imagePreview.src = '';
                        if (imageFilename) imageFilename.textContent = '';
                        return;
                    }
                    
                    // Validate file size
                    if (file.size > 2 * 1024 * 1024) {
                        if (imageError) {
                            imageError.textContent = 'Image is too large. Max size is 2MB.';
                            imageError.style.display = 'block';
                        }
                        imageInput.value = '';
                        imagePreviewContainer.style.display = 'none';
                        if (imagePreview) imagePreview.src = '';
                        if (imageFilename) imageFilename.textContent = '';
                        return;
                    }
                    
                    // Hide any previous errors
                    if (imageError) {
                        imageError.style.display = 'none';
                        imageError.textContent = '';
                    }
                    
                    // Show filename
                    if (imageFilename) {
                        imageFilename.textContent = 'Selected file: ' + file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                    }
                    
                    // Read and display the image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        console.log('FileReader loaded successfully');
                        if (imagePreview) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            imagePreview.onload = function() {
                                console.log('Image preview loaded and displayed');
                            };
                            imagePreview.onerror = function() {
                                console.error('Error loading image preview');
                            };
                        }
                        if (imagePreviewContainer) {
                            imagePreviewContainer.style.display = 'block';
                            console.log('Preview container displayed');
                        }
                    };
                    reader.onerror = function() {
                        console.error('FileReader error');
                        if (imageError) {
                            imageError.textContent = 'Failed to load image. Please try another file.';
                            imageError.style.display = 'block';
                        }
                    };
                    reader.readAsDataURL(file);
                }
                
                // Attach change event listener
                imageInput.addEventListener('change', function(e) {
                    console.log('File input changed');
                    const file = e.target.files && e.target.files[0];
                    if (file) {
                        console.log('File selected:', file.name);
                        displayPreview(file);
                    } else {
                        console.log('No file selected');
                        if (imagePreviewContainer) imagePreviewContainer.style.display = 'none';
                        if (imagePreview) imagePreview.src = '';
                        if (imageFilename) imageFilename.textContent = '';
                    }
                });
            }
            
            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initImagePreview);
            } else {
                initImagePreview();
            }
        })();

        const initReviewForm = () => {
            const form = document.getElementById('review-form');
            if (!form) return;

            const userName = @json(auth()->check() && auth()->user() ? auth()->user()->name : '');
            const submitBtn = document.getElementById('submit-review-btn');
            const successMsg = document.getElementById('review-success-message');
            const errorMsg = document.getElementById('review-error-message');
            const successText = document.getElementById('success-text');
            const errorText = document.getElementById('error-text');
            const imageInput = document.getElementById('image');
            const imageError = document.getElementById('image-error');
            const imagePreview = document.getElementById('image-preview');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            let currentObjectUrl = null;

            const resetPreview = () => {
                if (currentObjectUrl) {
                    URL.revokeObjectURL(currentObjectUrl);
                    currentObjectUrl = null;
                }
                if (imagePreview) {
                    imagePreview.src = '';
                }
                if (imagePreviewContainer) {
                    imagePreviewContainer.style.display = 'none';
                }
            };

            const validateImage = (file) => {
                if (!file) return null;
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    return 'Unsupported image type. Please use JPG, PNG, or WEBP.';
                }
                if (file.size > 2 * 1024 * 1024) {
                    return 'Image is too large. Max size is 2MB.';
                }
                return null;
            };

            const showImagePreview = (file) => {
                if (!file || !imagePreview || !imagePreviewContainer) {
                    resetPreview();
                    return;
                }
                
                // Clean up previous object URL
                if (currentObjectUrl) {
                    URL.revokeObjectURL(currentObjectUrl);
                }
                
                // Create new object URL and show preview
                currentObjectUrl = URL.createObjectURL(file);
                imagePreview.src = currentObjectUrl;
                imagePreviewContainer.style.display = 'block';
                
                // Ensure image loads
                imagePreview.onload = () => {
                    console.log('Image preview loaded successfully');
                };
                imagePreview.onerror = () => {
                    console.error('Failed to load image preview');
                    resetPreview();
                    if (imageError) {
                        imageError.textContent = 'Failed to load image preview. Please try another image.';
                        imageError.style.display = 'block';
                    }
                };
            };

            // Image preview is already handled by the script above
            // Just ensure we reset preview on form reset
            const handleImageChange = () => {
                if (!imageInput) return;
                const file = imageInput.files && imageInput.files[0];
                if (!file) {
                    resetPreview();
                }
            };

            imageInput?.addEventListener('change', handleImageChange);

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Hide previous messages
                successMsg.style.display = 'none';
                errorMsg.style.display = 'none';
                if (imageError) {
                    imageError.style.display = 'none';
                    imageError.textContent = '';
                }

                const file = imageInput && imageInput.files ? imageInput.files[0] : null;
                const validationMessage = validateImage(file);
                if (validationMessage) {
                    errorText.textContent = validationMessage;
                    errorMsg.style.display = 'block';
                    return;
                }

                const formData = new FormData(form);

                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';

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
                        successText.textContent = data.message;
                        successMsg.style.display = 'block';

                        const reviewsList = document.getElementById('reviews-list');
                        const reviewCount = document.getElementById('review-count');

                        if (reviewsList) {
                            const newReview = document.createElement('div');
                            newReview.className = 'review-box border rounded p-3 mb-3';
                            newReview.innerHTML = `
                                <strong>${data.review.name}</strong> — ⭐ ${data.review.rating}/5
                                <small class="text-muted d-block">${data.review.created_at}</small>
                                ${data.review.image_url ? `<div class="mt-2"><img src="${data.review.image_url}" alt="Review image" style="max-height: 100px;" class="rounded border"></div>` : ''}
                                ${data.review.comment ? `<p class="mb-0 mt-2">${data.review.comment}</p>` : ''}
                            `;
                            reviewsList.insertBefore(newReview, reviewsList.firstChild);

                            if (reviewCount) {
                                const currentCount = parseInt(reviewCount.textContent) || 0;
                                reviewCount.textContent = currentCount + 1;
                            }
                        } else {
                            const reviewsContainer = document.getElementById('reviews-container');
                            if (reviewsContainer) {
                                reviewsContainer.innerHTML = `
                                    <div class="product-reviews mt-5">
                                        <h4>Customer Reviews (<span id="review-count">1</span>)</h4>
                                        <div id="reviews-list">
                                            <div class="review-box border rounded p-3 mb-3">
                                                <strong>${data.review.name}</strong> — ⭐ ${data.review.rating}/5
                                                <small class="text-muted d-block">${data.review.created_at}</small>
                                                ${data.review.image_url ? `<div class="mt-2"><img src="${data.review.image_url}" alt="Review image" style="max-height: 100px;" class="rounded border"></div>` : ''}
                                                ${data.review.comment ? `<p class="mb-0 mt-2">${data.review.comment}</p>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                        }

                        // Reset form and preview
                        form.reset();
                        resetPreview();
                        if (userName && userName !== '') {
                            document.getElementById('review_name').value = userName;
                        }

                        successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    } else {
                        errorText.textContent = data.message || 'An error occurred. Please try again.';
                        errorMsg.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMessage = error.message || (typeof error === 'string' ? error : 'An error occurred. Please try again.');
                    errorText.textContent = errorMessage;
                    errorMsg.style.display = 'block';
                    errorMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit Review';
                });
            });

            // If a file was already selected (e.g., back/forward nav), show it.
            handleImageChange();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initReviewForm);
        } else {
            initReviewForm();
        }
    </script>

@endsection
