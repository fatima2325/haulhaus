@extends('frontend.layouts.main')

@section('main-container')

    <div class="container text-center my-4">
        <h1 style="color:#430a1e;">All Our Products</h1>
        <p style="color:rgba(94,5,27,0.73); font-size:18px;">
            <strong>Explore our exclusive collection of trendy Bags.</strong>
        </p>
    </div>

    {{-- Success message when a product is added to cart --}}
    @if(session('success'))
        <div class="container my-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Product Display Section --}}
    <div class="shop-page">
        @php
            // Fallback if controller not sending categoriesWithProducts
            $categoriesData = isset($categoriesWithProducts) && $categoriesWithProducts instanceof \Illuminate\Support\Collection
                ? $categoriesWithProducts
                : collect();
            $categoryLabels = $categoryLabels ?? [
                'tote' => 'Tote Bags',
                'bp' => 'Backpacks',
                'cb' => 'Cross Body Bags',
                'hobo' => 'Hobo Bags',
            ];
        @endphp

        @forelse($categoriesData as $categorySlug => $data)
            @php
                $category = $data['category'] ?? null;
                $products = $data['products'] ?? collect();
                $categoryTitle = $categoryLabels[$categorySlug] ?? ($category ? $category->name : ucfirst($categorySlug));
            @endphp

            <div class="small-container">
                <h2 class="title" id="{{ strtolower(str_replace(' ','-',$categoryTitle)) }}">
                    {{ $categoryTitle }}
                </h2>

                @if($products->count() > 0)
                    <div class="row justify-content-center">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex justify-content-center">
                                {{-- Make the entire card clickable --}}
                                <a href="{{ route('product.detail', [$categorySlug, $product->id]) }}"
                                   class="product-card-link"
                                   style="text-decoration: none; color: inherit; width: 100%;">
                                    <div class="card text-center product-box">
                                        <img src="{{ asset('frontend/images/' . trim($product->image)) }}"
                                             alt="{{ $product->name }}"
                                             class="product-image"
                                             onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'; this.onerror=null;">

                                        <div class="card-body">
                                            <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                            <p class="text-muted mb-2" style="font-size:13px;">
                                                Rs. {{ number_format($product->price) }}/-
                                            </p>
                                            <button type="button" class="btn btn-success btn-sm">
                                                View Description
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center my-4">
                        <div class="alert alert-info d-inline-block" role="alert" style="max-width: 500px;">
                            No products are available in the "{{ $categoryTitle }}" category yet. Please check back soon.
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center my-5">
                <div class="alert alert-warning d-inline-block" role="alert">
                    No categories found. Please add categories and products from the admin panel.
                </div>
            </div>
        @endforelse
    </div>

@endsection
