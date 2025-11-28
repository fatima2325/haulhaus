@extends('frontend.layouts.main')

@section('main-container')
<div class="container my-5">
    <h2 class="mb-4" style="color:#430a1e;">Order Details</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: #430a1e; color: white;">
            <h5 class="mb-0">Order Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($order->status == 'completed') bg-success
                            @elseif($order->status == 'processing') bg-info
                            @elseif($order->status == 'cancelled') bg-danger
                            @else bg-warning
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Total Amount:</strong> <strong style="color:#430a1e;">Rs. {{ number_format($order->total_amount) }}/-</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: #430a1e; color: white;">
            <h5 class="mb-0">Shipping Information</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header" style="background: #430a1e; color: white;">
            <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items ?? [] as $item)
                            <tr>
                                <td>{{ $item['product_name'] ?? 'Unknown Product' }}</td>
                                <td>Rs. {{ number_format($item['product_price'] ?? 0) }}/-</td>
                                <td>{{ $item['quantity'] ?? 0 }}</td>
                                <td>Rs. {{ number_format($item['subtotal'] ?? 0) }}/-</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th>Rs. {{ number_format($order->total_amount) }}/-</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>
@endsection

