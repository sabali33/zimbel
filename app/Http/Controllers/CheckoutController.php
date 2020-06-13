<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        //$gateway = Omnipay::create('Vantiv');
        return view('landing');
    }
    public function create(Product $product)
    {
        return view('checkout.create', compact('product'));
    }
}
