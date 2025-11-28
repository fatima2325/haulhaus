<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('category')->orderBy('name')->get();
        $isAdmin = auth()->check() && auth()->user()->name === 'admin';
        return view('admin.products.index', [
            'products' => $products,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get valid category slugs from database
        $validCategorySlugs = Category::pluck('slug')->toArray();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => ['required', 'in:' . implode(',', $validCategorySlugs)],
            'price' => 'required|numeric|min:0',
            'image' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reviews' => 'nullable|array',
        ]);

        // Trim whitespace from image filename
        $validated['image'] = trim($validated['image']);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Load reviews from database
        $product->load('reviews');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Get valid category slugs from database
        $validCategorySlugs = Category::pluck('slug')->toArray();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => ['required', 'in:' . implode(',', $validCategorySlugs)],
            'price' => 'required|numeric|min:0',
            'image' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reviews' => 'nullable|array',
        ]);

        // Trim whitespace from image filename
        $validated['image'] = trim($validated['image']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}

