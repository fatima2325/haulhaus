<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'reviews' => 'nullable|array',
        ]);

        // Require either uploaded image or filename
        if (!$request->hasFile('image_file') && !$request->filled('image')) {
            return back()->withInput()->withErrors([
                'image' => 'Please provide an image filename or upload an image.',
            ]);
        }

        // Trim whitespace from image filename when provided
        if ($request->filled('image')) {
            $validated['image'] = trim($validated['image']);
        }

        $this->handleImageUpload($request, $validated);

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
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'reviews' => 'nullable|array',
        ]);

        if (!$request->hasFile('image_file') && !$request->filled('image')) {
            return back()->withInput()->withErrors([
                'image' => 'Please provide an image filename or upload an image.',
            ]);
        }

        if ($request->filled('image')) {
            $validated['image'] = trim($validated['image']);
        }

        $this->handleImageUpload($request, $validated);

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

    /**
     * Ajax search for products by name and category.
     */
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($inner) use ($query) {
                    $inner->where('name', 'like', '%' . $query . '%')
                        ->orWhere('category', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('name')
            ->limit(10)
            ->get();

        $categories = [
            'hobo' => 'Hobo Bags',
            'cb' => 'Cross Body Bags',
            'bp' => 'Backpacks',
            'tote' => 'Tote Bags'
        ];

        $results = $products->map(function ($product) use ($categories) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $categories[$product->category] ?? ucfirst($product->category),
                'price' => $product->price,
                'image' => asset('frontend/images/' . trim($product->image)),
                'show_url' => route('admin.products.show', $product),
            ];
        });

        return response()->json(['data' => $results]);
    }

    /**
     * Handle optional image upload, storing in public/frontend/images.
     */
    protected function handleImageUpload(Request $request, array &$validated): void
    {
        if (!$request->hasFile('image_file')) {
            return;
        }

        $file = $request->file('image_file');
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($baseName);
        $extension = $file->getClientOriginalExtension();
        $fileName = $safeName ? $safeName . '-' . time() . '.' . $extension : time() . '.' . $extension;

        $destination = public_path('frontend/images');
        File::ensureDirectoryExists($destination);
        $file->move($destination, $fileName);

        $validated['image'] = $fileName;
    }
}

