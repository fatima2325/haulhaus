@extends('admin.layout')

@section('title', 'Edit Category')
@section('header', 'Edit Category')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-3xl font-bold mb-2 text-center" style="color: #430a1e;">Edit Category</h3>
        </div>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6 px-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'"
                    placeholder="e.g., Hobo Bags">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 px-4">
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-left" style="color: #430a1e;">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200 resize-y"
                    onfocus="this.style.borderColor='#6c1835'"
                    onblur="this.style.borderColor='#d1d5db'"
                    placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-center space-x-4 mt-6 pt-6 mb-8 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.categories.index') }}" 
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
                    <i class="fas fa-save mr-2"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

