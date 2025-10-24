<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class hoboController extends Controller
{
    public function home(){
        return view('frontend.hobo');
    }
}
