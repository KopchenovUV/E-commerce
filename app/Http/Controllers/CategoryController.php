<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::query();

        // Фильтр по категориям
        if ($request->has('category_id') && $request->category_id) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category_id);
            });
        }

        // Фильтр по цене
        if ($request->has('max_price') && $request->max_price) {
            $products->where('price', '<=', $request->max_price);
        }

        // Поиск
        if ($request->has('search') && $request->search) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $products->get();
        return view('categories.index', compact('categories', 'products'));
    }
}