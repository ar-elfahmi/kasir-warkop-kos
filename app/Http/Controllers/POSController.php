<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function __construct(
        protected CartService $cart
    ) {}

    public function index()
    {
        $categories = Category::all();
        $menuItems = MenuItem::with('variants', 'toppings', 'category')->get();
        $cartItems = $this->cart->items();
        $cartTotal = $this->cart->total();

        return view('pos.index', compact('categories', 'menuItems', 'cartItems', 'cartTotal'));
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:variants,id',
            'qty' => 'required|integer|min:1',
            'toppings' => 'nullable|array',
            'toppings.*.id' => 'required|exists:toppings,id',
            'toppings.*.price' => 'required|integer|min:0',
            'toppings.*.name' => 'required|string',
        ]);

        $this->cart->addItem(
            $validated['variant_id'],
            $validated['qty'],
            $validated['toppings'] ?? []
        );

        return redirect('/pos');
    }

    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
        ]);

        $this->cart->removeItem($validated['key']);

        return redirect('/pos');
    }

    public function clearCart()
    {
        $this->cart->clear();

        return redirect('/pos');
    }
}
