<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use App\Models\Variant;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $variants = Variant::with('menuItem.category')->get();
        $stockEntries = StockEntry::with('variant.menuItem')->latest()->get();

        return view('stock.index', compact('variants', 'stockEntries'));
    }

    public function restock()
    {
        $variants = Variant::with('menuItem')->get();

        return view('stock.restock', compact('variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:variants,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $variant = Variant::findOrFail($validated['variant_id']);
        $variant->increment('stock', $validated['quantity']);

        StockEntry::create([
            'variant_id' => $variant->id,
            'quantity' => $validated['quantity'],
            'note' => $validated['note'],
        ]);

        return redirect('/stock');
    }
}
