@extends('frontend.layouts.main')

@section('main-container')
<div class="container my-5">
    <h2 class="mb-4 text-center" style="color:#430a1e;">My Orders</h2>

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead style="background: #430a1e; color: white;">
                    <tr>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>Rs. {{ number_format($order->total_amount) }}/-</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'completed') bg-success
                                    @elseif($order->status == 'processing') bg-info
                                    @elseif($order->status == 'cancelled') bg-danger
                                    @else bg-warning
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->payment_method }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center my-5">
            <p class="lead">You haven't placed any orders yet.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection


