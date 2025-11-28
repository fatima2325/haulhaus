@extends('admin.layout')

@section('title', 'Product Details')
@section('header', 'Product Details')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="text-center">
                <h3 class="text-3xl font-bold mb-2" style="color: #430a1e;">Product Details</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('frontend/images/' . trim($product->image)) }}" 
                     alt="{{ $product->name }}" 
                     class="h-auto rounded-lg shadow-md border-2 border-gray-200 mb-6" style="max-width: 200px; width: 200px; height: auto;"
                     onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'; this.onerror=null;">
                <h2 class="text-3xl font-bold text-center mb-8" style="color: #430a1e;">{{ $product->name }}</h2>
                
                <div class="mt-4 pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-center space-x-4 w-full">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 120px; height: 38px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-edit mr-2"></i> Edit Product
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                style="background: #6c1835; color: white; min-width: 120px; height: 38px;"
                                onmouseover="this.style.background='#49091f'"
                                onmouseout="this.style.background='#6c1835'"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fas fa-trash mr-2"></i> Delete Product
                        </button>
                    </form>
                </div>
            </div>
            
            <div>
                
                <div class="space-y-6">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Category</label>
                        <p class="text-lg font-semibold" style="color: #430a1e;">
                            @php
                                $category = \App\Models\Category::where('slug', $product->category)->first();
                                $categoryName = $category ? $category->name : ucfirst($product->category);
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" style="background: #f8d7e0; color: #430a1e;">
                                {{ $categoryName }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Price</label>
                        <p class="text-2xl font-bold" style="color: #430a1e;">Rs. {{ number_format($product->price) }}/-</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Description</label>
                        <p class="text-gray-900 dark:text-gray-100 leading-relaxed">{{ $product->description ?? 'No description available.' }}</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Image Filename</label>
                        <p class="text-gray-900 dark:text-gray-100 font-mono text-sm">{{ $product->image }}</p>
                    </div>
                    
                    @php
                        // Get reviews from database relationship (explicitly use relationship, not the casted attribute)
                        $productReviews = $product->reviews()->get();
                    @endphp
                    @if($productReviews->count() > 0)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Reviews ({{ $productReviews->count() }})</label>
                            <div class="mt-2 space-y-2">
                                @foreach($productReviews->sortByDesc('created_at') as $review)
                                    <div class="bg-white dark:bg-gray-600 p-3 rounded border border-gray-200 dark:border-gray-500">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $review->name ?? 'Anonymous' }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Rating: ⭐ {{ $review->rating ?? 'N/A' }}/5</p>
                                        @if($review->comment)
                                            <p class="text-sm text-gray-700 dark:text-gray-200 mt-1">{{ $review->comment }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Reviews</label>
                            <p class="text-sm text-gray-600 dark:text-gray-400">No reviews yet for this product.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

