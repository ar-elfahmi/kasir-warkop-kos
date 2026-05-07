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
            'stock' => ['required', 'integer'],
        ]);

        Variant::create($validated);

        return redirect('/dashboard');
    }
}
