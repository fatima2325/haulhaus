<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    public function home(){
        return $this->viewCart();
    }

    public function viewCart()
    {

        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        // Prevent admin from adding to cart
        if (auth()->check() && auth()->user()->name === 'admin') {
            return redirect()->back()->with('error', 'Admin users cannot add products to cart. Please use the admin panel to manage products.');
        }

        $request->validate([
            'product_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'product_name' => 'required|string',
            'product_price' => 'required|numeric',
            'product_image' => 'nullable|string',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $name = $request->input('product_name');
        $price = $request->input('product_price');
        $imagePath = $request->input('product_image');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {

            $cart[$productId]['quantity'] += $quantity;
        } else {

            $cart[$productId] = [
                "id" => $productId,
                "name" => $name,
                "quantity" => $quantity,
                "price" => $price,
                "image" => $imagePath,
            ];
        }

        session()->put('cart', $cart);


        return redirect()->back()->with('success', $name . ' added to cart successfully!');
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $name = $cart[$id]['name'] ?? 'Item';
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->flash('success', $name . ' removed successfully.');
        }


        return redirect()->route('cart.view');
    }



    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.view')->with('success', 'Your cart has been cleared.');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            if ($request->action === 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($request->action === 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }


    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('frontend.checkout', compact('cart', 'total'));
    }

    public function confirmCheckout(Request $request)
    {
        // Prevent admin from checking out
        if (auth()->check() && auth()->user()->name === 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Admin users cannot place orders. Please use the admin panel to manage the system.');
        }

        // Validate input - if validation fails, Laravel will redirect back to checkout
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:COD,Card,Bank',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('checkout')
                ->with('error', 'Your cart is empty. Please add items to your cart first.');
        }

        $total = 0;
        $totalQuantity = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $totalQuantity += $item['quantity'];
        }

        // Generate unique order number
        $orderNumber = 'HH-' . strtoupper(uniqid());
        $orderDate = now()->format('F d, Y');

        try {
            // Use database transaction to ensure atomicity
            DB::beginTransaction();

            // Prepare all order items as an array
            $orderItems = [];
            foreach ($cart as $cartItem) {
                // Convert product_id to integer if it's numeric, otherwise set to null
                $productId = null;
                if (isset($cartItem['id']) && is_numeric($cartItem['id'])) {
                    $productId = (int)$cartItem['id'];
                }
                
                $orderItems[] = [
                    'product_id' => $productId,
                    'product_name' => $cartItem['name'] ?? 'Unknown Product',
                    'product_price' => (float)($cartItem['price'] ?? 0),
                    'quantity' => (int)($cartItem['quantity'] ?? 1),
                    'subtotal' => (float)($cartItem['price'] ?? 0) * (int)($cartItem['quantity'] ?? 1),
                    'image' => $cartItem['image'] ?? null,
                ];
            }

            // Create order in database with all items in one column
            // user_id can be null for guest orders
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->check() ? auth()->id() : null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'total_amount' => $total,
                'total_quantity' => $totalQuantity,
                'status' => 'pending',
                'items' => $orderItems, // Store all items as JSON in one column
            ]);

            // Commit transaction
            DB::commit();

            // Clear the cart only after successful order creation
            session()->forget('cart');

            // Redirect to thankyou page with order details
            return redirect()->route('thankyou')->with([
                'success' => 'Thank you for your purchase, ' . $validated['name'] . '!',
                'orderId' => $orderNumber,
                'orderDate' => $orderDate,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
            ]);
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            Log::error('Order creation failed: ' . $e->getMessage(), [
                'cart' => $cart,
                'validated' => $validated,
                'trace' => $e->getTraceAsString()
            ]);

            // Redirect back to checkout with error message
            return redirect()->route('checkout')
                ->withInput()
                ->with('error', 'Failed to process your order: ' . $e->getMessage() . '. Please try again.');
        }
    }


}
