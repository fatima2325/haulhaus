@extends('frontend.layouts.main')
@section('main-container')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <br><br>
                <h1><strong>TRENDURA</strong></h1>
                <h1>Pack smart, look sharp</h1>
                <p>Explore beautifully crafted bags designed with care and attention to detail.<br>
                    Every piece tells a story — made by hand, made for you.</p>
                <a href="{{ url('shop') }}" class="btn">Shop Now &#8594;</a>
            </div>

            <div class="col-2">
                <img src="{{ url('frontend/images/banner.png') }}" class="bottom-img" alt="Handcrafted Bag">
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="small-container">
            <br><br>
            <h2 class="title">Our Collections</h2>
            <div class="row">
                <div class="col-3">
                    {{-- Navigates to shop page, jumps to hobo-bags section --}}
                    <a href="{{ url('shop') }}#hobo-bags">
                        <img src="{{ url('frontend/images/hobo bag.png') }}" alt="Hobo Bags">
                        <h3>Hobo Bags</h3>
                    </a>
                </div>
                <div class="col-3">
                    {{-- Navigates to shop page, jumps to tote-bags section --}}
                    <a href="{{ url('shop') }}#tote-bags">
                        <img src="{{ url('frontend/images/tote bags.png') }}" alt="Tote Bags">
                        <h3>Tote Bags</h3>
                    </a>
                </div>
                <div class="col-3">
                    {{-- Navigates to shop page, jumps to backpacks section --}}
                    <a href="{{ url('shop') }}#backpacks">
                        <img src="{{ url('frontend/images/backpacks.png') }}" alt="Backpacks">
                        <h3>Backpacks</h3>
                    </a>
                </div>
                <div class="col-3">
                    {{-- Navigates to shop page, jumps to cross-body-bags section --}}
                    <a href="{{ url('shop') }}#cross-body-bags">
                        <img src="{{ url('frontend/images/cross bosy bags.png') }}" alt="Crossbody Bags">
                        <h3>Crossbody Bags</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="small-container">
        <h2 class="title">Featured Products</h2>
        <div class="row">
            @php
                // NOTE: This array contains the full image path, which is passed to the CartController.
                $products = [
                    [
                        'id' => 1,
                        'name'=>'Cherry Classic Hobo',
                        'image'=>'frontend/images/habo bag2.jpg',
                        'price'=>'2,200',
                        'raw_price' => 2200,
                        'description'=>'A beautiful handcrafted hobo bag made with premium materials.',
                        'reviews'=>[
                            ['user'=>'Sara', 'comment'=>'Love this bag! Very stylish and durable.'],
                            ['user'=>'Ali', 'comment'=>'The perfect size for daily use.'],
                        ]
                    ],
                    [
                        'id' => 2,
                        'name'=>'Everyday Tote',
                        'image'=>'frontend/images/totebag7.jpg',
                        'price'=>'3,000',
                        'raw_price' => 3000,
                        'description'=>'A spacious tote bag perfect for everyday use.',
                        'reviews'=>[
                            ['user'=>'Fatima', 'comment'=>'Great tote! Fits all my essentials.'],
                            ['user'=>'Hassan', 'comment'=>'Beautiful design and very practical.'],
                        ]
                    ],
                    [
                        'id' => 3,
                        'name'=>'Red Leather',
                        'image'=>'frontend/images/backpack3.jpg',
                        'price'=>'3,800',
                        'raw_price' => 3800,
                        'description'=>'Stylish red leather backpack for your daily adventures.',
                        'reviews'=>[
                            ['user'=>'Amir', 'comment'=>'Leather quality is top-notch.'],
                            ['user'=>'Zara', 'comment'=>'I get compliments everywhere I go!'],
                        ]
                    ],
                    [
                        'id' => 4,
                        'name'=>'Mini Crossbody',
                        'image'=>'frontend/images/crossbody3.jpg',
                        'price'=>'2,500',
                        'raw_price' => 2500,
                        'description'=>'Compact crossbody bag for essential items.',
                        'reviews'=>[
                            ['user'=>'Noor', 'comment'=>'Perfect for quick outings.'],
                            ['user'=>'Bilal', 'comment'=>'Small but holds everything I need.'],
                        ]
                    ]
                ];
            @endphp

            @foreach($products as $index => $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 text-center product-box">
                        <div class="product-card" data-bs-toggle="modal" data-bs-target="#productModal{{ $index }}">
                            {{-- Image display on Home Page using url() helper --}}
                            <img src="{{ url($product['image']) }}" alt="{{ $product['name'] }}" class="product-image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text text-muted mb-2">Rs. {{ $product['price'] }}/-</p>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewsModal{{ $index }}">Reviews</button>

                                {{-- ADD TO CART FORM --}}
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf

                                    {{-- The 'product_image' hidden field stores the full path (frontend/images/...) --}}
                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                                    <input type="hidden" name="product_price" value="{{ $product['raw_price'] }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="product_image" value="{{ basename($product['image']) }}">

                                    <button type="submit" class="btn btn-success btn-sm">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Modal (Description) --}}
                <div class="modal fade" id="productModal{{ $index }}" tabindex="-1" aria-labelledby="productModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel{{ $index }}">{{ $product['name'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ url($product['image']) }}" class="img-fluid mb-3" alt="{{ $product['name'] }}">
                                <p>{{ $product['description'] }}</p>
                                <p><strong>Price:</strong> Rs. {{ $product['price'] }}/-</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reviews Modal --}}
                <div class="modal fade" id="reviewsModal{{ $index }}" tabindex="-1" aria-labelledby="reviewsModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewsModalLabel{{ $index }}">Reviews for {{ $product['name'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if(!empty($product['reviews']))
                                    <ul class="list-unstyled">
                                        @foreach($product['reviews'] as $review)
                                            <li class="mb-2"><strong>{{ $review['user'] }}:</strong> {{ $review['comment'] }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No reviews yet. Be the first to review!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cart Success Modal (Optional, kept for completeness) --}}
                <div class="modal fade" id="cartModal{{ $index }}" tabindex="-1" aria-labelledby="cartModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cartModalLabel{{ $index }}">Cart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>{{ $product['name'] }} has been added to your cart!</p>
                                <a href="{{ url('cart') }}" class="btn btn-success">Go to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="about-us mt-5">
            <div class="container">
                <h2 class="title">Our Story & Commitment</h2>
                <div class="row">
                    <div class="col-2 about-text">
                        <h3>More than just bags—it's craftsmanship.</h3>
                        <p>
                            Trendura Bags was founded on the belief that quality shouldn't compromise style. We hand-select premium, sustainable materials to ensure every bag is not only beautiful but durable enough for your everyday life.
                        </p>
                        <p>
                            From our minimalist crossbody styles to our spacious tote bags, we design with purpose, focusing on functional details like secure pockets and comfortable straps. We are committed to ethical production and bringing you accessories that elevate your style journey.
                        </p>
                    </div>
                    <div class="col-2 about-image">
                        <img src="{{ url('frontend/images/about.png') }}" alt="Image representing craftsmanship or team">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

        /* --- Product Box --- */
        .product-box {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
            background: #fff;
            width: 90%;
            max-width: 230px;
            margin: 0 auto;
        }
        .product-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }


        .product-image {
            width: 100%;
            height: 180px;
            object-fit: contain;
            border-radius: 10px;
            background-color: #f9f9f9;
            padding: 10px;
        }

        /* --- Card Body --- */
        .card-body {
            padding: 8px;
            min-height: 90px;
        }

        /* --- Buttons --- */
        .btn-sm {
            padding: 5px 12px;
            font-size: 13px;
        }
    </style>


@endsection
