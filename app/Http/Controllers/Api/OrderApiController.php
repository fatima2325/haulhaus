<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $orders]);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order]);
    }

    public function store(Request $request): JsonResponse
    {
        // Simple order creation API
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'items' => 'required|array',
            'total_amount' => 'required|numeric'
        ]);

        $order = Order::create([
            'order_number' => 'API-' . strtoupper(uniqid()),
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'payment_method' => 'API',
            'total_amount' => $validated['total_amount'],
            'status' => 'pending',
            'items' => $validated['items']
        ]);

        return response()->json(['data' => $order, 'message' => 'Order created'], 201);
    }
}
