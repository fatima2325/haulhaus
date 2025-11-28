@extends('frontend.layouts.main')

@section('main-container')
    <div class="container text-center my-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="mb-4" style="color:#430a1e;">Order Confirmed!</h1>
        <p class="lead">We’ve received your order and will contact you soon with the shipping details.</p>

        <div class="card mx-auto mt-4 shadow-sm" style="max-width: 500px; border: 1px solid #eee;">
            <div class="card-body">
                <h5 class="mb-3" style="color:#430a1e;">Order Summary</h5>

                <p><strong>Order ID:</strong> {{ session('orderId') ?? 'N/A' }}</p>
                <p><strong>Order Date:</strong> {{ session('orderDate') ?? now()->format('F d, Y') }}</p>
                <p><strong>Payment Method:</strong> {{ $paymentMethod ?? session('payment_method') ?? 'N/A' }}</p>
                <p><strong>Total Amount:</strong> <span class="text-success fw-bold">Rs. {{ number_format(session('total') ?? 0) }}/-</span></p>
                <p><strong>Total Paid:</strong> 
                    @php
                        $paymentMethodValue = $paymentMethod ?? session('payment_method');
                    @endphp
                    @if($paymentMethodValue && strtoupper(trim($paymentMethodValue)) === 'COD')
                        <span class="text-success fw-bold">Rs. 0/-</span>
                        <br><small class="text-muted">(Payment on delivery)</small>
                    @else
                        <span class="text-success fw-bold">Rs. {{ number_format(session('total') ?? 0) }}/-</span>
                    @endif
                </p>

                <hr>

                <p class="mt-3">A confirmation email will be sent to you shortly.</p>
            </div>
        </div>

            <div class="mt-4 d-flex justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-primary mx-1 px-4">Go Back To Home</a>
                <a href="{{ route('shop') }}" class="btn btn-primary mx-1 px-4">Continue Shopping</a>
            </div>



    </div>
@endsection
