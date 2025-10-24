@extends('frontend.layouts.main')
@section('main-container')

    <div class="container text-center my-4">
        <h1 style="color:#430a1e;">All Our Products</h1>
        <p style="color:rgba(94,5,27,0.73); font-size:18px;">
            <strong>Explore our exclusive collection of trendy Bags.</strong>
        </p>
    </div>



    @if(session('success'))
        <div class="container my-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="shop-page">

        @php

            $reviewsById = [
                101 => [['user'=>'Fatima','text'=>'Absolutely stunning leather and impeccable stitching!'], ['user'=>'Ali','text'=>'My go-to bag for work now.'], ['user'=>'Sana','text'=>'Exceeded my expectations!']],
                102 => [['user'=>'Ayesha','text'=>'Perfect size for my everyday essentials.'], ['user'=>'Waqar','text'=>'The color is much richer in person.'], ['user'=>'Hira','text'=>'Highly recommend this design.']],
                103 => [['user'=>'Mariam','text'=>'Very light and comfortable to carry.'], ['user'=>'Zain','text'=>'Great value for the quality.'], ['user'=>'Noor','text'=>'Stylish and durable.']],
                104 => [['user'=>'Ahmed','text'=>'Love the structure and unique shape.'], ['user'=>'Sara','text'=>'Gets compliments every time I use it.'], ['user'=>'Kamran','text'=>'A fantastic purchase, no regrets.']],
                105 => [['user'=>'Zara','text'=>'The hardware feels premium and solid.'], ['user'=>'Ehsan','text'=>'Holds more than I thought it would.'], ['user'=>'Minahil','text'=>'Classic style that works with everything.']],
                106 => [['user'=>'Bilal','text'=>'Easy to clean and maintain.'], ['user'=>'Shazia','text'=>'A very practical and chic bag.'], ['user'=>'Faizan','text'=>'Ideal for weekend travel.']],
                107 => [['user'=>'Nida','text'=>'The inner lining is beautiful and functional.'], ['user'=>'Usman','text'=>'Great for organizing my laptop and notebook.'], ['user'=>'Rizwan','text'=>'Top-notch craftsmanship.']],
                108 => [['user'=>'Javeria','text'=>'Comfortable shoulder strap.'], ['user'=>'Omar','text'=>'I bought two in different colors!'], ['user'=>'Aisha','text'=>'Best bag purchase this year.']],
                201 => [['user'=>'Sadia','text'=>'Perfect mini crossbody for outings.'], ['user'=>'Hassan','text'=>'Love the vibrant color.'], ['user'=>'Iqra','text'=>'Compact yet spacious.']],
                202 => [['user'=>'Aliya','text'=>'Stylish and functional.'], ['user'=>'Farhan','text'=>'Excellent quality leather.'], ['user'=>'Sarah','text'=>'Highly versatile bag.']],
                203 => [['user'=>'Tariq','text'=>'Very durable and lightweight.'], ['user'=>'Maryam','text'=>'Perfect for office use.'], ['user'=>'Bilal','text'=>'Amazing design.']],
                204 => [['user'=>'Fariha','text'=>'Great value for money.'], ['user'=>'Hamza','text'=>'Convenient and stylish.'], ['user'=>'Zoya','text'=>'I use it daily.']],
                205 => [['user'=>'Rashid','text'=>'Ideal size for essentials.'], ['user'=>'Hina','text'=>'Very chic and modern.'], ['user'=>'Adeel','text'=>'Highly recommended.']],
                206 => [['user'=>'Sami','text'=>'Love the compartments.'], ['user'=>'Laiba','text'=>'Perfect bag for city trips.'], ['user'=>'Usama','text'=>'Well made and durable.']],
                207 => [['user'=>'Fatima','text'=>'Beautiful finish and color.'], ['user'=>'Omar','text'=>'A real head-turner.'], ['user'=>'Sara','text'=>'Fits all my stuff.']],
                208 => [['user'=>'Zain','text'=>'Elegant and practical.'], ['user'=>'Hira','text'=>'Perfect for gifting.'], ['user'=>'Ahmed','text'=>'Superb quality.']],
                301 => [['user'=>'Ali','text'=>'Spacious and sturdy.'], ['user'=>'Sana','text'=>'Perfect for travel.'], ['user'=>'Mariam','text'=>'Love the leather texture.']],
                302 => [['user'=>'Usman','text'=>'Very comfortable to wear.'], ['user'=>'Nida','text'=>'Great for office use.'], ['user'=>'Bilal','text'=>'High-quality backpack.']],
                303 => [['user'=>'Aisha','text'=>'Lots of compartments.'], ['user'=>'Ahmed','text'=>'Perfect for school.'], ['user'=>'Hira','text'=>'Durable and strong.']],
                304 => [['user'=>'Fatima','text'=>'Stylish and modern.'], ['user'=>'Zara','text'=>'Can carry all essentials.'], ['user'=>'Omar','text'=>'Very premium look.']],
                305 => [['user'=>'Sara','text'=>'Comfortable and trendy.'], ['user'=>'Ali','text'=>'Easy to clean.'], ['user'=>'Noor','text'=>'Love the color.']],
                306 => [['user'=>'Bilal','text'=>'Perfect for hiking.'], ['user'=>'Hira','text'=>'Excellent build quality.'], ['user'=>'Zain','text'=>'Fits everything.']],
                307 => [['user'=>'Ayesha','text'=>'Sleek and modern design.'], ['user'=>'Ahmed','text'=>'Durable straps.'], ['user'=>'Sana','text'=>'Very handy bag.']],
                308 => [['user'=>'Usman','text'=>'Classic canvas look.'], ['user'=>'Mariam','text'=>'Ideal for daily use.'], ['user'=>'Omar','text'=>'Sturdy and light.']],
                401 => [['user'=>'Fatima','text'=>'Perfect everyday tote.'], ['user'=>'Ali','text'=>'Love the size and style.'], ['user'=>'Sana','text'=>'Very practical.']],
                402 => [['user'=>'Ayesha','text'=>'Great commuter bag.'], ['user'=>'Waqar','text'=>'Looks premium.'], ['user'=>'Hira','text'=>'Excellent leather.']],
                403 => [['user'=>'Mariam','text'=>'Fits my laptop perfectly.'], ['user'=>'Zain','text'=>'Very functional.'], ['user'=>'Noor','text'=>'Stylish.']],
                404 => [['user'=>'Ahmed','text'=>'Perfect for beach trips.'], ['user'=>'Sara','text'=>'Lightweight and roomy.'], ['user'=>'Kamran','text'=>'Great material.']],
                405 => [['user'=>'Zara','text'=>'Love the color.'], ['user'=>'Ehsan','text'=>'Spacious.'], ['user'=>'Minahil','text'=>'Perfect for shopping.']],
                406 => [['user'=>'Bilal','text'=>'Mini but very practical.'], ['user'=>'Shazia','text'=>'Very chic.'], ['user'=>'Faizan','text'=>'High quality.']],
                407 => [['user'=>'Nida','text'=>'Structured and elegant.'], ['user'=>'Usman','text'=>'Very stylish.'], ['user'=>'Rizwan','text'=>'Top-notch craftsmanship.']],
                408 => [['user'=>'Javeria','text'=>'Eco-friendly and sturdy.'], ['user'=>'Omar','text'=>'Love the jute texture.'], ['user'=>'Aisha','text'=>'Perfect for groceries.']],
            ];


            // Define products
            $hoboItems = [
                ['name'=>'Cherry Classic Hobo','image'=>'habo bag2.jpg','price'=>2200,'id'=>101],
                ['name'=>'Stow','image'=>'habo bag13.jpg','price'=>2500,'id'=>102],
                ['name'=>'Moss Drop','image'=>'habo bag1.jpg','price'=>2100,'id'=>103],
                ['name'=>'Ledge','image'=>'habo bag3.jpg','price'=>2700,'id'=>104],
                ['name'=>'Bordeaux','image'=>'habo bag4.jpg','price'=>2300,'id'=>105],
                ['name'=>'Laguna Hobo','image'=>'habo bag6.jpg','price'=>2400,'id'=>106],
                ['name'=>'Cienna','image'=>'habo bag7.jpg','price'=>2950,'id'=>107],
                ['name'=>'Verona','image'=>'habo bags.webp','price'=>2650,'id'=>108],
            ];
            $cbItems = [
                ['name'=>'Mini Cross Body','image'=>'crossbody3.jpg','price'=>3200,'id'=>201],
                ['name'=>'Meridian','image'=>'cross body1.jpg','price'=>2500,'id'=>202],
                ['name'=>'Urban Scout','image'=>'cross body2.jpg','price'=>3000,'id'=>203],
                ['name'=>'Quick Draw','image'=>'crossbody4.jpg','price'=>2700,'id'=>204],
                ['name'=>'Commuter Compact','image'=>'crossbody5.jpg','price'=>3600,'id'=>205],
                ['name'=>'Traverse','image'=>'cb6.jpg','price'=>2450,'id'=>206],
                ['name'=>'Memento','image'=>'cb7.jpg','price'=>2100,'id'=>207],
                ['name'=>'The Envelope','image'=>'cb8.jpg','price'=>2850,'id'=>208],
            ];
            $bpItems = [
                ['name'=>'Red Leather','image'=>'backpack3.jpg','price'=>3800,'id'=>301],
                ['name'=>'Metropolis','image'=>'backpack1.jpg','price'=>2500,'id'=>302],
                ['name'=>'The Slug','image'=>'bp11.jpg','price'=>3500,'id'=>303],
                ['name'=>'Zephyr','image'=>'backpacks.jpg','price'=>4800,'id'=>304],
                ['name'=>'Stride','image'=>'bp4.jpg','price'=>2700,'id'=>305],
                ['name'=>'Summit','image'=>'bp5.jpg','price'=>3800,'id'=>306],
                ['name'=>'Wayfarer','image'=>'bp6.jpg','price'=>2750,'id'=>307],
                ['name'=>'Canvas Cube','image'=>'bp7.jpg','price'=>4000,'id'=>308],
            ];
            $toteItems = [
                ['name'=>'Everyday Tote','image'=>'totebag7.jpg','price'=>3000,'id'=>401],
                ['name'=>'Leather Commuter','image'=>'tote bag.jpg','price'=>2300,'id'=>402],
                ['name'=>'Laptop Work Tote','image'=>'totebag5.jpg','price'=>2900,'id'=>403],
                ['name'=>'Mesh Beachcomber Tote','image'=>'totebag6.jpg','price'=>2450,'id'=>404],
                ['name'=>'Vanilla Voyager','image'=>'totebag8.jpg','price'=>2700,'id'=>405],
                ['name'=>'Mini Tote','image'=>'tote bag9.jpg','price'=>3200,'id'=>406],
                ['name'=>'Structured Bucket Tote','image'=>'tote bag10.jpg','price'=>3250,'id'=>407],
                ['name'=>'Eco-Jute Market Tote','image'=>'totebag12.jpg','price'=>3600,'id'=>408],
            ];

            $collections = [
                'Hobo Bags' => ['tag'=>'Hobo','items'=>$hoboItems],
                'Cross Body Bags' => ['tag'=>'CrossBody','items'=>$cbItems],
                'Backpacks' => ['tag'=>'Backpack','items'=>$bpItems],
                'Tote Bags' => ['tag'=>'Tote','items'=>$toteItems],
            ];


            $allModals = [];
            foreach ($collections as $categoryTitle => $collection) {
                foreach ($collection['items'] as $index => $product) {
                    $allModals[] = [
                        'category' => $collection['tag'],
                        'product' => $product
                    ];
                }
            }
        @endphp


        @foreach($collections as $categoryTitle => $collection)
            <div class="small-container">
                <h2 class="title" id="{{ strtolower(str_replace(' ','-',$categoryTitle)) }}">{{ $categoryTitle }}</h2>
                <div class="row justify-content-center">
                    @foreach($collection['items'] as $index => $product)
                        @php $modalId = $collection['tag'] . $product['id']; @endphp
                        <div class="col-lg-2 col-md-3 col-sm-6 mb-4 d-flex justify-content-center">
                            <div class="card text-center product-box">
                                <div class="product-card" data-bs-toggle="modal" data-bs-target="#descModal{{ $modalId }}">
                                    <img src="{{ asset('frontend/images/' . $product['image']) }}" alt="{{ $product['name'] }}" class="product-image">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title mb-1">{{ $product['name'] }}</h6>
                                    <p class="text-muted mb-2" style="font-size:13px;">Rs. {{ number_format($product['price']) }}/-</p>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewsModal{{ $modalId }}">Reviews</button>
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                            <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                                            <input type="hidden" name="product_price" value="{{ $product['price'] }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="product_image" value="{{ $product['image'] }}">
                                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- --- MODALS SECTION --- --}}
    @foreach($allModals as $data)
        @php
            $categoryTag = $data['category'];
            $product = $data['product'];
            $modalId = $categoryTag . $product['id'];
            $categoryName = strtolower($categoryTag) . ' bag';
            $reviews = $reviewsById[$product['id']] ?? [];
        @endphp

        {{-- Description Modal --}}
        <div class="modal fade" id="descModal{{ $modalId }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $product['name'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('frontend/images/' . $product['image']) }}" class="img-fluid mb-3" alt="{{ $product['name'] }}">
                        <p>A premium-quality {{ $categoryName }} designed for style and convenience. Perfect for daily or travel use.</p>
                        <p><strong>Price:</strong> Rs. {{ number_format($product['price']) }}/-</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews Modal --}}
        <div class="modal fade" id="reviewsModal{{ $modalId }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reviews for {{ $product['name'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-unstyled">
                            @foreach($reviews as $review)
                                <li class="mb-2"><strong>{{ $review['user'] }}:</strong> {{ $review['text'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .product-box {
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 10px;
            background: #fff;
            transition: all 0.3s ease;
            max-width: 180px;
            width: 100%;
            margin: 0 auto;
            padding: 8px;
        }

        .product-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        .product-card {
            cursor: pointer;
        }
        .product-image {
            width: 100%;
            height: 140px;
            object-fit: contain;
            border-radius: 8px;
            background-color: #fafafa;
            padding: 8px;
        }
        .card-body {
            padding: 8px;
            min-height: 90px;
        }
        .card-title {
            font-size: 14px;
            font-weight: 600;
        }
        .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }
        .title {
            text-align: center;
            margin: 30px 0 20px;
            color: #430a1e;
            font-weight: 700;
        }
        .small-container {
            margin-bottom: 50px;
        }
    </style>

@endsection
