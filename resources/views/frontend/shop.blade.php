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
            $categories = \App\Models\Category::orderBy('name')->get()->keyBy('slug');
        @endphp
        @foreach($groupedProducts as $categorySlug => $products)
            @php
                $category = $categories->get($categorySlug);
                $categoryTitle = $category ? $category->name : ucfirst($categorySlug);
            @endphp

            <div class="small-container">
                <h2 class="title" id="{{ strtolower(str_replace(' ','-',$categoryTitle)) }}">
                    {{ $categoryTitle }}
                </h2>

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
            </div>
        @endforeach
    </div>

@endsection
