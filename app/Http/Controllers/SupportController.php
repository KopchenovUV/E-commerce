<?php

namespace App\Http\Controllers;

use App\Models\SupportChat;
use App\Models\SupportTicket;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = SupportChat::where('user_id', Auth::id())->orderBy('created_at')->get();
        return view('support.index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $userId = Auth::id();

        SupportChat::create([
            'user_id' => $userId,
            'message' => $message,
            'sender' => 'user',
        ]);

        $botResponse = $this->processUserMessage($message);

        SupportChat::create([
            'user_id' => $userId,
            'message' => $botResponse,
            'sender' => 'bot',
        ]);

        return response()->json(['response' => $botResponse]);
    }

    public function submitComplaint(Request $request)
    {
        $userId = Auth::id();
        $complaint = $request->input('complaint');

        SupportTicket::create([
            'user_id' => $userId,
            'problem' => $complaint,
            'status' => 'pending',
        ]);

        SupportChat::create([
            'user_id' => $userId,
            'message' => 'Ваша жалоба принята и передана оператору.',
            'sender' => 'bot',
        ]);

        return response()->json(['message' => 'Ваша жалоба принята и передана оператору.']);
    }

    private function processUserMessage($message)
    {
        $message = strtolower($message);

        if (str_contains($message, 'доставка')) {
            return 'Уточните, пожалуйста, о какой доставке идёт речь? Например, сроки, стоимость или регионы?';
        } elseif (str_contains($message, 'оплата')) {
            return 'Вы хотите узнать о способах оплаты? Уточните, интересует ли вас оплата онлайн или при получении.';
        } elseif (str_contains($message, 'товар')) {
            $categories = Category::pluck('name')->implode(', ');
            return "У нас есть следующие категории товаров: $categories. Какой категории товар вас интересует?";
        } else {
            return 'Простите, я не понял ваш вопрос. Можете уточнить, о чём именно вы спрашиваете?';
        }
    }

    public function getProductsByCategory($categoryName)
    {
        $category = Category::where('name', 'like', '%' . $categoryName . '%')->first();
        if ($category) {
            $products = $category->products()->get(['name']);
            return response()->json(['products' => $products]);
        }
        return response()->json(['products' => []]);
    }

    public function getProductDetails($productName)
    {
        $product = Product::where('name', 'like', '%' . $productName . '%')->first();
        if ($product) {
            return response()->json(['product' => $product]);
        }
        return response()->json(['product' => null]);
    }
}