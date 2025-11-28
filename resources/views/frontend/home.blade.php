@extends('frontend.layouts.main')

@section('main-container')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <br><br>
                <h1>Pack smart, look sharp</h1>
                <p>
                    Explore beautifully crafted bags designed with care and attention to detail.<br>
                    Every piece tells a story — made by hand, made for you.
                </p>
                <a href="{{ url('shop') }}" class="btn">Shop Now &#8594;</a>
            </div>

            <div class="col-2">
                <img src="{{ url('frontend/images/banner.png') }}" class="bottom-img" alt="Handcrafted Bag">
            </div>
        </div>
    </div>

    {{-- Category section --}}
    <div class="categories">
        <div class="small-container">
            <br><br>
            <h2 class="title">Our Collections</h2>
            <div class="row">
                <div class="col-3">
                    <a href="{{ url('shop') }}#hobo-bags">
                        <img src="{{ url('frontend/images/hobo bag.png') }}" alt="Hobo Bags">
                        <h3>Hobo Bags</h3>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ url('shop') }}#tote-bags">
                        <img src="{{ url('frontend/images/tote bags.png') }}" alt="Tote Bags">
                        <h3>Tote Bags</h3>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ url('shop') }}#backpacks">
                        <img src="{{ url('frontend/images/backpacks.png') }}" alt="Backpacks">
                        <h3>Backpacks</h3>
                    </a>
                </div>
                <div class="col-3">
                    <a href="{{ url('shop') }}#cross-body-bags">
                        <img src="{{ url('frontend/images/cross bosy bags.png') }}" alt="Crossbody Bags">
                        <h3>Crossbody Bags</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Featured products section --}}
    <div class="small-container">
        <h2 class="title">Featured Products</h2>

        @if(isset($featuredProducts) && $featuredProducts->count() > 0)
            <div class="row justify-content-center">
                @foreach($featuredProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex justify-content-center">
                        <a href="{{ route('product.detail', [$product->category, $product->id]) }}"
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
            <p class="text-center text-muted">No featured products available at the moment.</p>
        @endif
    </div>

    {{-- About section --}}
    <div class="about-us mt-5">
        <div class="container">
            <h2 class="title">Our Story & Commitment</h2>
            <div class="row">
                <div class="col-2 about-text">
                    <h3>More than just bags—it's craftsmanship.</h3>
                    <p>
                        Haul Haus Bags was founded on the belief that quality shouldn't compromise style.
                        We hand-select premium, sustainable materials to ensure every bag is not only beautiful
                        but durable enough for your everyday life.
                    </p>
                    <p>
                        From our minimalist crossbody styles to our spacious tote bags, we design with purpose,
                        focusing on functional details like secure pockets and comfortable straps.
                        We are committed to ethical production and bringing you accessories that elevate your style journey.
                    </p>
                </div>
                <div class="col-2 about-image">
                    <img src="{{ url('frontend/images/about.png') }}" alt="Image representing craftsmanship or team">
                </div>
            </div>
        </div>
    </div>

@endsection
