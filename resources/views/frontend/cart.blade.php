@extends('frontend.layouts.main')
@section('main-container')

    <div class="cart-page">
        <div class="cart-container">
            <div class="cart-header">
                <h1>Your Cart</h1>
            </div>

            {{-- Success Message Alert --}}
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @php
                $total = 0;
                $itemCount = count($cart);
            @endphp

            @if($itemCount === 0)
                <p class="empty">Your cart is empty.</p>

                {{-- Always show Back to Shopping --}}
                <div class="cart-buttons" style="text-align:center; margin-top: 20px;">
                    <a href="{{ url('shop') }}" class="btn">Back to Shopping</a>
                </div>
            @else
                <div class="cart-items">
                    @foreach($cart as $id => $item)
                        @php
                            $price = (float) ($item['price'] ?? 0);
                            $quantity = (int) ($item['quantity'] ?? 0);
                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                            $imagePath = $item['image'] ?? null;
                        @endphp

                        <div class="cart-item">
                            <div class="cart-item-info">
                                @if($imagePath)
                                    <img src="{{ asset('frontend/images/' . trim($imagePath)) }}" alt="{{ $item['name'] ?? 'Product' }}" onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'; this.onerror=null;">
                                @else
                                    <div class="no-image">No Image</div>
                                @endif
                                <div>
                                    <h4>{{ $item['name'] ?? 'Unknown Product' }}</h4>
                                    <p>Price: Rs. {{ number_format($price) }}/-</p>

                                    {{-- Quantity with + and – buttons --}}
                                    <div class="quantity-controls">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="decrease" class="qty-btn">−</button>
                                        </form>

                                        <span class="mx-2 fw-bold">{{ $quantity }}</span>

                                        <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="increase" class="qty-btn">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-actions">
                                <p class="subtotal">Subtotal: Rs. {{ number_format($subtotal) }}/-</p>

                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn"
                                            onclick="return confirm('Are you sure you want to remove this item?');">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <h3>Total: Rs. {{ number_format($total, 0) }}/-</h3>
                    <div class="cart-buttons d-flex justify-content-center align-items-center mt-4 gap-2">
                        <a href="{{ url('shop') }}" class="btn custom-btn">Back to Shopping</a>

                        <form action="{{ route('cart.clear') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn custom-btn"
                                    onclick="return confirm('Are you sure you want to clear your cart?');">
                                Clear Cart
                            </button>
                        </form>

                        <a href="{{ route('checkout') }}" class="btn custom-btn">Proceed to Checkout</a>
                    </div>

                </div>
            @endif
        </div>


    </div>
@endsection
