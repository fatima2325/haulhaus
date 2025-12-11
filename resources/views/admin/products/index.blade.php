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

        <div class="mt-4">
            <div class="relative max-w-lg">
                <label for="product-search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1" style="color: #430a1e;">Search by Name or Category</label>
                <input type="text" id="product-search" placeholder="Start typing to search..."
                       class="w-full rounded-lg border-2 border-gray-300 shadow-sm px-4 py-2.5 transition-colors duration-200"
                       onfocus="this.style.borderColor='#6c1835'"
                       onblur="this.style.borderColor='#d1d5db'">
                <div id="search-results" class="absolute left-0 right-0 bg-white shadow-lg rounded-lg mt-1 border border-gray-200 z-10" style="display: none; max-height: 240px; overflow-y: auto;">
                    <ul class="divide-y divide-gray-200" id="search-results-list"></ul>
                </div>
            </div>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('product-search');
        const resultsBox = document.getElementById('search-results');
        const resultsList = document.getElementById('search-results-list');
        const searchUrl = "{{ route('admin.products.search') }}";
        let debounceTimer;

        const hideResults = () => {
            if (resultsBox) {
                resultsBox.style.display = 'none';
                resultsList.innerHTML = '';
            }
        };

        const renderResults = (items) => {
            if (!resultsBox || !resultsList) return;
            resultsList.innerHTML = '';

            if (!items.length) {
                resultsList.innerHTML = '<li class="px-4 py-3 text-sm text-gray-500">No matches found</li>';
                resultsBox.style.display = 'block';
                return;
            }

            items.forEach(item => {
                const li = document.createElement('li');
                li.className = 'px-4 py-3 hover:bg-gray-50 cursor-pointer flex items-center space-x-3';
                li.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="h-10 w-10 object-cover rounded border border-gray-200">
                    <div class="flex-1">
                        <div class="text-sm font-semibold" style="color: #430a1e;">${item.name}</div>
                        <div class="text-xs text-gray-600">${item.category} &middot; Rs. ${Number(item.price).toLocaleString()}</div>
                    </div>
                    <div class="text-xs text-blue-600">View</div>
                `;
                li.addEventListener('click', () => {
                    window.location.href = item.show_url;
                });
                resultsList.appendChild(li);
            });

            resultsBox.style.display = 'block';
        };

        searchInput?.addEventListener('keyup', () => {
            const query = searchInput.value.trim();
            clearTimeout(debounceTimer);

            if (!query) {
                hideResults();
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => renderResults(data.data || []))
                    .catch(() => hideResults());
            }, 250);
        });

        document.addEventListener('click', (e) => {
            if (!resultsBox || !resultsBox.contains(e.target) && e.target !== searchInput) {
                hideResults();
            }
        });
    });
</script>
@endsection

