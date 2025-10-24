<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ProductData;

class shopController extends Controller
{
    use ProductData;

    public function shop(Request $request)
    {
        // Get sort query from GET (?sort=low_high or ?sort=high_low)
        $sort = $request->query('sort', '');

        $allProducts = collect($this->getProducts());

        if ($sort === 'low_high') {
            $sortedProducts = $allProducts->sortBy('price');
        } elseif ($sort === 'high_low') {
            $sortedProducts = $allProducts->sortByDesc('price');
        } else {
            $sortedProducts = $allProducts->sortBy('name');
        }

        $groupedProducts = $sortedProducts->groupBy('category');

        return view('frontend.shop', [
            'groupedProducts' => $groupedProducts,
            'sort' => $sort
        ]);
    }
}
