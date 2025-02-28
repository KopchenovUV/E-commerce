<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Добавление в избранное
    public function add($id)
    {
        $user = Auth::user();
        $exists = Favorite::where('user_id', $user->id)->where('product_id', $id)->exists();

        if (!$exists) {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $id,
            ]);
            return redirect()->back()->with('success', 'Добавлено в избранное');
        }

        return redirect()->back()->with('error', 'Уже в избранном');
    }

    // Удаление из избранного
    public function remove($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())->where('product_id', $id)->firstOrFail();
        $favorite->delete();
        return redirect()->back()->with('success', 'Удалено из избранного');
    }

    // Страница избранного
    public function index()
    {
        $favorite = Favorite::with('product')->where('user_id', Auth::id())->get();
        return view('favorites.index', compact('favorite'));
    }

    public function clear()
    {
        Favorite::where('user_id', Auth::id())->delete();
        return redirect()->route('favorites.index')->with('success', 'Список избранного очищен');
    }
}