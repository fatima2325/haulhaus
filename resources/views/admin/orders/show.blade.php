@extends('admin.layout')

@section('title', 'Order Details')
@section('header', 'Order Details')

@section('content')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
    <div class="p-6 sm:p-8">
        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-3xl font-bold mb-2" style="color: #430a1e;">Order Details</h3>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="px-4 py-2 rounded-md text-sm font-semibold border-2"
                                style="border-color: #6c1835; color: #430a1e;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-4 py-2 rounded-md text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
                                style="background: #6c1835; color: white; min-width: 120px; height: 32px;"
                                onmouseover="this.style.background='#49091f'"
                                onmouseout="this.style.background='#6c1835'"
                                onclick="return confirm('Are you sure you want to delete this order?')">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Order Number</label>
                <p class="text-lg font-bold" style="color: #430a1e;">{{ $order->order_number }}</p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Order Date</label>
                <p class="text-gray-900 dark:text-gray-100">{{ $order->created_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Status</label>
                <p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Payment Method</label>
                <p class="text-gray-900 dark:text-gray-100">{{ $order->payment_method }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Customer Name</label>
                <p class="text-lg font-semibold" style="color: #430a1e;">{{ $order->name }}</p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Email</label>
                <p class="text-gray-900 dark:text-gray-100">
                    <a href="mailto:{{ $order->email }}" class="text-blue-600 hover:text-blue-800">{{ $order->email }}</a>
                </p>
            </div>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Shipping Address</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $order->address }}</p>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
            <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2 block">Order Items</label>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-600 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2 text-left text-xs font-semibold">Product</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">Price</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">Quantity</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items ?? [] as $item)
                            <tr class="border-b border-gray-200 dark:border-gray-500">
                                <td class="px-4 py-2 text-sm">{{ $item['product_name'] ?? 'Unknown Product' }}</td>
                                <td class="px-4 py-2 text-sm">Rs. {{ number_format($item['product_price'] ?? 0) }}/-</td>
                                <td class="px-4 py-2 text-sm">{{ $item['quantity'] ?? 0 }}</td>
                                <td class="px-4 py-2 text-sm font-semibold">Rs. {{ number_format($item['subtotal'] ?? 0) }}/-</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <td colspan="3" class="px-4 py-2 text-right font-bold">Total:</td>
                            <td class="px-4 py-2 font-bold text-lg" style="color: #430a1e;">Rs. {{ number_format($order->total_amount) }}/-</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.orders.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md"
               style="background: #6c1835; color: white; min-width: 140px; height: 38px;"
               onmouseover="this.style.background='#49091f'"
               onmouseout="this.style.background='#6c1835'">
                <i class="fas fa-arrow-left mr-2"></i> Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection

