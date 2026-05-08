<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\StockEntry;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->get();
        $stockEntries = StockEntry::with('menuItem')->latest()->get();

        return view('stock.index', compact('menuItems', 'stockEntries'));
    }

    public function restock()
    {
        $menuItems = MenuItem::with('variants')->get();

        return view('stock.restock', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $menuItem = MenuItem::findOrFail($validated['menu_item_id']);
        $menuItem->increment('stock', $validated['quantity']);

        StockEntry::create([
            'menu_item_id' => $menuItem->id,
            'quantity' => $validated['quantity'],
            'note' => $validated['note'],
        ]);

        return redirect('/stock');
    }
}
