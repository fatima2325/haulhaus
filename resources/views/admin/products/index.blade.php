@extends('admin.layout')

@section('title', 'Products Management')
@section('header', 'Products Management')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2" style="color: #430a1e;">All Products</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage your product inventory</p>
            </div>
            @auth
                @if(auth()->user()->name === 'admin')
                    <a href="{{ route('admin.products.create') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 rounded-full text-white font-semibold text-sm transition-all duration-300 shadow-md hover:shadow-lg"
                       style="background: #6c1835; color: white;"
                       onmouseover="this.style.background='#49091f'"
                       onmouseout="this.style.background='#6c1835'">
                        <i class="fas fa-plus mr-2"></i> Add New Product
                    </a>
                @endif
            @else
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login as admin</a> to manage products
                </div>
            @endauth
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full shadow-md rounded-lg overflow-hidden" style="border-collapse: separate; border-spacing: 0 12px;">
                <thead>
                    <tr style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Image</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Price</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider" style="color: #430a1e;">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-150" style="background: white; margin-bottom: 12px; border-bottom: 2px solid #e5e7eb;">
                            <td class="px-6 py-6 whitespace-nowrap text-sm font-semibold text-gray-700">{{ $product->id }}</td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <img src="{{ asset('frontend/images/' . trim($product->image)) }}" alt="{{ $product->name }}" class="h-14 w-14 object-cover rounded-md shadow-sm border border-gray-300" onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'; this.onerror=null;">
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold" style="color: #430a1e;">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm text-gray-700">
                                    @php
                                        $categories = [
                                            'hobo' => 'Hobo Bags',
                                            'cb' => 'Cross Body Bags',
                                            'bp' => 'Backpacks',
                                            'tote' => 'Tote Bags'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background: #f8d7e0; color: #430a1e;">
                                        {{ $categories[$product->category] ?? ucfirst($product->category) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">Rs. {{ number_format($product->price) }}/-</div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap text-sm font-medium">
                                @auth
                                    @if(auth()->user()->name === 'admin')
                                        <div class="flex items-center justify-center space-x-4">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                               style="background: #6c1835; color: white; min-width: 80px; height: 32px;"
                                               onmouseover="this.style.background='#49091f'"
                                               onmouseout="this.style.background='#6c1835'"
                                               title="View Details">
                                                <i class="fas fa-eye mr-1.5"></i> View
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                               style="background: #6c1835; color: white; min-width: 80px; height: 32px;"
                                               onmouseover="this.style.background='#49091f'"
                                               onmouseout="this.style.background='#6c1835'"
                                               title="Edit Product">
                                                <i class="fas fa-edit mr-1.5"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                                        style="background: #6c1835; color: white; min-width: 80px; height: 32px;"
                                                        onmouseover="this.style.background='#49091f'"
                                                        onmouseout="this.style.background='#6c1835'"
                                                        onclick="return confirm('Are you sure you want to delete this product?')" 
                                                        title="Delete Product">
                                                    <i class="fas fa-trash mr-1.5"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-center block">Admin only</span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-center block">Login required</span>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-box-open text-4xl mb-3" style="color: #d1d5db;"></i>
                                    <p class="text-sm font-medium text-gray-500">No products found in the database.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

