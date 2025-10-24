<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class staticPagesController extends Controller
{

    public function terms()
    {
        return view('frontend.terms');
    }

    public function returns()
    {
        return view('frontend.returns');
    }

}
