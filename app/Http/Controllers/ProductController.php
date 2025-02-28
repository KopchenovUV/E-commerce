<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        $cartQuantity = Auth::check() ? Cart::where('user_id', Auth::id())->where('product_id', $id)->value('quantity') : 0;

        if (Auth::check()) {
            Auth::user()->load('favorites');
        }

        return view('product.show', compact('product', 'cartQuantity'));
    }
}