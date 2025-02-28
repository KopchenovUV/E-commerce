<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->has('search') && $request->search) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $products->get();
        return view('home', compact('products'));
    }
}