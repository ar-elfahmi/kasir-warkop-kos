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

    public function adjust()
    {
        $menuItems = MenuItem::with('variants')->get();

        return view('stock.adjust', compact('menuItems'));
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
            'type' => 'restock',
        ]);

        return redirect('/stock');
    }

    public function storeAdjust(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
            'adjustment_type' => 'required|in:adjustment_increase,adjustment_decrease',
        ]);

        $menuItem = MenuItem::findOrFail($validated['menu_item_id']);

        if ($validated['adjustment_type'] === 'adjustment_increase') {
            $menuItem->increment('stock', $validated['quantity']);
            $type = 'adjustment_increase';
        } else {
             // Check if we have enough stock to decrease
              if ($menuItem->stock < $validated['quantity']) {
                  return redirect()->back()
                      ->withInput()
                      ->withErrors(['quantity' => 'Stok tidak cukup untuk dikurangi']);
              }
            $menuItem->decrement('stock', $validated['quantity']);
            $type = 'adjustment_decrease';
        }

        StockEntry::create([
            'menu_item_id' => $menuItem->id,
            'quantity' => $validated['quantity'],
            'note' => $validated['note'],
            'type' => $type,
        ]);

        return redirect('/stock');
    }
}
