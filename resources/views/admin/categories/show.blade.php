@extends('admin.layout')

@section('title', 'Category Details')
@section('header', 'Category Details')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="text-center">
                <h3 class="text-3xl font-bold mb-2" style="color: #430a1e;">Category Details</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col items-center justify-center">
                <h2 class="text-3xl font-bold text-center mb-8" style="color: #430a1e;">{{ $category->name }}</h2>
                
                <div class="mt-4 pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-center space-x-4 w-full">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                       style="background: #6c1835; color: white; min-width: 120px; height: 38px;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-edit mr-2"></i> Edit Category
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                style="background: #6c1835; color: white; min-width: 120px; height: 38px;"
                                onmouseover="this.style.background='#49091f'"
                                onmouseout="this.style.background='#6c1835'"
                                onclick="return confirm('Are you sure you want to delete this category?')">
                            <i class="fas fa-trash mr-2"></i> Delete Category
                        </button>
                    </form>
                </div>
            </div>
            
            <div>
                <div class="space-y-6">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Description</label>
                        <p class="text-gray-900 dark:text-gray-100 leading-relaxed">{{ $category->description ?? 'No description available.' }}</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Products Count</label>
                        <p class="text-2xl font-bold" style="color: #430a1e;">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" style="background: #f8d7e0; color: #430a1e;">
                                {{ \App\Models\Product::where('category', $category->slug)->count() }} products
                            </span>
                        </p>
                    </div>

                    @php
                        $categoryProducts = \App\Models\Product::where('category', $category->slug)->get();
                    @endphp
                    @if($categoryProducts->count() > 0)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Associated Products</label>
                            <div class="mt-2 space-y-2">
                                @foreach($categoryProducts->take(5) as $product)
                                    <div class="bg-white dark:bg-gray-600 p-3 rounded">
                                        <p class="font-semibold text-sm">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">Rs. {{ number_format($product->price) }}/-</p>
                                    </div>
                                @endforeach
                                @if($categoryProducts->count() > 5)
                                    <p class="text-xs text-gray-500 italic">... and {{ $categoryProducts->count() - 5 }} more</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

