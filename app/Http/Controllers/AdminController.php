<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SupportTicket;
use App\Models\SupportChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Только авторизованные пользователи имеют доступ
    }

    /**
     * Отображение главной страницы админ-панели с товарами и заявками
     */
    public function index()
    {
        $products = Product::with('categories')->get(); // Загружаем товары с их категориями
        $tickets = SupportTicket::with('user')->get(); // Загружаем заявки с данными пользователей
        return view('admin.index', compact('products', 'tickets'));
    }

    /**
     * Отображение формы для создания нового товара
     */
    public function create()
    {
        $categories = Category::all(); // Все категории для выбора
        return view('admin.create', compact('categories'));
    }

    /**
     * Сохранение нового товара
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // Максимум 2MB
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Сохранение изображения, если оно загружено
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Создание товара
        $product = Product::create($data);

        // Привязка категорий
        $product->categories()->sync($data['categories']);

        return redirect()->route('admin.index')->with('success', 'Товар добавлен');
    }

    /**
     * Отображение формы для редактирования товара
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    /**
     * Обновление товара
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        // Обновление изображения
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image); // Удаляем старое изображение
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Обновление товара
        $product->update($data);
        $product->categories()->sync($data['categories']);

        return redirect()->route('admin.index')->with('success', 'Товар обновлён');
    }

    /**
     * Удаление товара
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Удаление изображения, если оно есть
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Удаление связей с категориями и самого товара
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Товар удалён');
    }

    /**
     * Обновление статуса заявки на поддержку
     */
    public function updateTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $status = $request->input('status');
        $ticket->update(['status' => $status]);
        // Уведомление пользователя в чате
        if ($status !== 'pending') {
            SupportChat::create([
                'user_id' => $ticket->user_id,
                'message' => "Ваша жалоба '$ticket->problem' была " . ($status === 'resolved' ? 'решена' : 'отклонена'),
                'sender' => 'bot',
            ]);
        }

        return redirect()->route('admin.index')->with('success', 'Статус жалобы обновлён');
    }
}