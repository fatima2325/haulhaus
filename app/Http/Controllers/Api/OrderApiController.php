<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderApiController extends Controller
{
    /**
     * Get all orders
     * If user is authenticated, returns only their orders.
     * If not authenticated, returns all orders (for testing/demo purposes).
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // If user is authenticated, show only their orders
        if (Auth::check()) {
            $orders = Order::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // For unauthenticated requests, return all orders (useful for testing/demo)
            $orders = Order::orderBy('created_at', 'desc')
                ->get();
        }
        
        return response()->json([
            'success' => true,
            'data' => $orders,
            'message' => 'Orders retrieved successfully'
        ]);
    }

    /**
     * Get a specific order by ID
     * If user is authenticated, only returns their own orders.
     * If not authenticated, returns any order (for testing/demo purposes).
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        // If user is authenticated, only show their orders
        if (Auth::check()) {
            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();
        } else {
            // For unauthenticated requests, return any order (useful for testing/demo)
            $order = Order::find($id);
        }
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order retrieved successfully'
        ]);
    }
}


