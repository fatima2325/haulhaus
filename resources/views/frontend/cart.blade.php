@extends('frontend.layouts.main')
@section('main-container')

    <div class="container my-5">
        <h1 class="text-center" style="color:#430a1e;">Your Cart</h1>

        @php
            $total = 0;
            $itemCount = count($cart);
        @endphp

        {{-- Success Message Alert--}}
        @if(session('success'))
            <div class="container my-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div id="cartItems" class="row justify-content-center mt-4">

            @if($itemCount > 0)
                <div class="col-lg-8">
                    @foreach($cart as $id => $item)
                        @php
                            $price = (float) ($item['price'] ?? 0);
                            $quantity = (int) ($item['quantity'] ?? 0);
                            $subtotal = $price * $quantity;
                            $total += $subtotal;


                            $imagePath = $item['image'] ?? null;
                        @endphp

                        <div class="d-flex align-items-center cart-product-box p-3 mb-3 border bg-light">


                            <div style="width: 80px; height: 80px; margin-right: 15px;">
                                @if($imagePath)
                                    {{-- Assumes path is relative to the public/frontend/images directory --}}
                                    <img src="{{ asset('frontend/images/' . $imagePath) }}"
                                         alt="{{ $item['name'] ?? 'Product' }}"
                                         style="width: 100%; height: 100%; object-fit: contain; border-radius: 5px; background: #fff;">
                                @else
                                    {{-- Placeholder if image path is missing --}}
                                    <div style="width: 100%; height: 100%; background: #eee; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #888;">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow-1 text-start">
                                <h5>{{ $item['name'] ?? 'Unknown Product (Error in Session)' }}</h5>
                                <p class="mb-1">Price: Rs. {{ number_format($price) }}/-</p>
                                <p class="mb-0">Quantity: <strong>{{ $quantity }}</strong></p>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-end me-4">
                                <strong>Subtotal:</strong> Rs. {{ number_format($subtotal) }}/-
                            </div>


                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to remove this item?');">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center">Your cart is empty.</p>
            @endif

        </div>

        {{-- Cart Total --}}
        <div id="cartTotal" class="text-center mt-4 p-3 border-top border-bottom mx-auto" style="font-size:24px; color:#430a1e; max-width: 500px;">
            <strong>Total: Rs. {{ number_format($total) }}/-</strong>
        </div>

        {{-- Action Buttons --}}
        <div class="text-center mt-4 d-flex justify-content-center gap-3">

            {{-- Clear Cart Button  --}}
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn custom-btn" {{ $itemCount === 0 ? 'disabled' : '' }}
                onclick="return confirm('Are you sure you want to clear your cart?');">
                    Clear Cart
                </button>
            </form>

            {{-- Go Back button --}}
            <a href="{{ url('shop') }}" class="btn custom-btn">Continue Shopping</a>


        </div>
    </div>

    <style>

        .custom-btn {
            background-color: #430a1e;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .custom-btn:hover:not(:disabled) {
            background-color: #320413;
        }
        .custom-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }
        .cart-product-box {
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: left;
        }
        .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }
    </style>

@endsection
