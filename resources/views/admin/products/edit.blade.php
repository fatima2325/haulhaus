@extends('admin.layout')

@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-3xl font-bold mb-2 text-center" style="color: #430a1e;">Edit Product</h3>
        </div>
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6 px-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 px-4">
                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Category</label>
                <select name="category" id="category" required
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ old('category', $product->category) == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 px-4">
                <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'">
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 px-4">
                <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Image Filename</label>
                <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}" placeholder="e.g., habo bag2.jpg" required
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'">
                <p class="mt-2 text-xs text-gray-500 italic">Enter the filename from the frontend/images folder</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 px-4">
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200 resize-y"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-center space-x-4 mt-6 pt-6 mb-8 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                   style="background: #6c1835; color: white; min-width: 140px; height: 38px;"
                   onmouseover="this.style.background='#49091f'"
                   onmouseout="this.style.background='#6c1835'">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                        style="background: #6c1835; color: white; min-width: 140px; height: 38px;"
                        onmouseover="this.style.background='#49091f'"
                        onmouseout="this.style.background='#6c1835'">
                    <i class="fas fa-save mr-2"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

