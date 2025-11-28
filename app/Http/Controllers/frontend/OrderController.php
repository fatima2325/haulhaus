<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display order history for authenticated users
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Items are now stored in the items JSON column
        return view('frontend.orders.show', compact('order'));
    }
}
