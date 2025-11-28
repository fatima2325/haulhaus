<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class homeController extends Controller
{
    public function home(){
        // Get one featured product from each category
        $categories = ['hobo', 'tote', 'bp', 'cb']; // Category slugs
        $featuredProducts = collect();
        
        foreach ($categories as $category) {
            // Get the first product from this category (or most recent)
            $product = Product::where('category', $category)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($product) {
                $featuredProducts->push($product);
            }
        }
        
        return view('frontend.home', [
            'featuredProducts' => $featuredProducts
        ]);
    }
}
