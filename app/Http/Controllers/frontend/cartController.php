<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Assuming this model exists

class CartController extends Controller
{
    /**
     * Display the shopping cart view.
     */
    public function home(){
        return $this->viewCart();
    }

    /**
     * Displays the current contents of the shopping cart.
     */
    public function viewCart()
    {
        // Retrieve the cart data from the session. This is what populates the view.
        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
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
            // Item already exists, increment quantity
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

        // Redirect back, triggering the page reload and success message display
        return redirect()->back()->with('success', $name . ' added to cart successfully!');
    }

    /**
     * Removes a single item from the cart.
     */
    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $name = $cart[$id]['name'] ?? 'Item';
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->flash('success', $name . ' removed successfully.');
        }

        // Redirect back to the cart view to show the updated list
        return redirect()->route('cart.view');
    }

    /**
     * Clears all items from the cart.
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.view')->with('success', 'Your cart has been cleared.');
    }
}
