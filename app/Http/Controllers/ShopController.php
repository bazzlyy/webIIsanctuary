<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('sizes')->get();
        return view('shop.index', compact('products'));
    }

    public function show($id)
{
    $product = \App\Models\Product::with('sizes')->findOrFail($id);
    return view('shop.show', compact('product'));
}
}