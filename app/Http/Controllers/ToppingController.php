<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::with('menuItems')->get();

        if (request()->expectsJson()) {
            return $toppings;
        }

        return view('toppings.index', compact('toppings'));
    }

    public function create()
    {
        return view('toppings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $topping = Topping::create($validated);

        if ($request->expectsJson()) {
            return $topping;
        }

        return redirect()->route('toppings.index');
    }

    public function edit(Topping $topping)
    {
        return view('toppings.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $topping->update($validated);

        if ($request->expectsJson()) {
            return $topping;
        }

        return redirect()->route('toppings.index');
    }

    public function destroy(Topping $topping)
    {
        $topping->menuItems()->detach();
        $topping->delete();

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('toppings.index');
    }

    public function assignToMenuItem(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => ['required', 'exists:menu_items,id'],
            'topping_ids' => ['required', 'array'],
            'topping_ids.*' => ['exists:toppings,id'],
        ]);

        $menuItem = MenuItem::findOrFail($validated['menu_item_id']);
        $menuItem->toppings()->sync($validated['topping_ids']);

        return $menuItem->load('toppings');
    }
}
