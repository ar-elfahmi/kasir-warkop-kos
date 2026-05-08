<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => ['required', 'exists:menu_items,id'],
            'size' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $variant = Variant::create($validated);

        return redirect()->route('menu-items.edit', $variant->menu_item_id);
    }
}
