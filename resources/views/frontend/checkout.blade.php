@extends('frontend.layouts.main')

@section('main-container')

    <div class="container my-5">
        <h2 class="mb-4 text-center" style="color:#430a1e;">Checkout Summary</h2>

        {{-- Success alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Error alert --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(empty($cart))
            <div class="text-center my-5">
                <h5>Your cart is empty!</h5>
                <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Go Back to Shop</a>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-4 shadow-sm">
                        <h4 class="mb-3">Products in Your Cart</h4>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td><img src="{{ asset('frontend/images/' . trim($item['image'])) }}" width="60" height="60" alt="" onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'; this.onerror=null;"></td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>Rs. {{ number_format($item['price']) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>Rs. {{ number_format($item['price'] * $item['quantity']) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h5 class="text-end mt-3">Grand Total: <strong>Rs. {{ number_format($total) }}/-</strong></h5>
                        <div class="text-end mt-2">
                            <p class="mb-0"><strong>Total Paid:</strong> 
                                <span id="totalPaid" class="text-success">Rs. {{ number_format($total) }}/-</span>
                            </p>
                            <small id="paymentNote" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-4 shadow-sm">
                        <h4 class="mb-3">Shipping Information</h4>

                        <form action="{{ route('checkout.confirm') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Shipping Address</label>
                                <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required onchange="updateTotalPaid()">
                                    <option value="">Select Method</option>
                                    <option value="COD" {{ old('payment_method') == 'COD' ? 'selected' : '' }}>Cash on Delivery</option>
                                    <option value="Card" {{ old('payment_method') == 'Card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                    <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100">Confirm Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        const totalAmount = {{ $total }};
        
        function updateTotalPaid() {
            const paymentMethod = document.getElementById('payment_method').value;
            const totalPaidElement = document.getElementById('totalPaid');
            const paymentNoteElement = document.getElementById('paymentNote');
            
            if (paymentMethod === 'COD') {
                totalPaidElement.textContent = 'Rs. 0/-';
                totalPaidElement.className = 'text-success';
                paymentNoteElement.textContent = '(Payment on delivery)';
                paymentNoteElement.className = 'text-muted';
            } else if (paymentMethod === 'Card' || paymentMethod === 'Bank') {
                totalPaidElement.textContent = 'Rs. ' + totalAmount.toLocaleString('en-IN') + '/-';
                totalPaidElement.className = 'text-success';
                paymentNoteElement.textContent = '';
                paymentNoteElement.className = '';
            } else {
                totalPaidElement.textContent = 'Rs. ' + totalAmount.toLocaleString('en-IN') + '/-';
                totalPaidElement.className = 'text-success';
                paymentNoteElement.textContent = '';
                paymentNoteElement.className = '';
            }
        }
        
        // Update on page load if payment method is already selected
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalPaid();
        });
    </script>

@endsection
