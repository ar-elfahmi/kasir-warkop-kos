<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->get();
        return view('menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        MenuItem::create($validated);

        return redirect()->route('menu-items.index');
    }

    public function edit(string $id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $menuItem->update($validated);

        return redirect()->route('menu-items.index');
    }

    public function destroy(string $id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return redirect()->route('menu-items.index');
    }
}
