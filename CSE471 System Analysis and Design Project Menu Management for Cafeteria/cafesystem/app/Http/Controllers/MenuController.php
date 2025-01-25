<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItems;

class MenuController extends Controller
{
    public function view(Request $request)
    {
        $sortBy = $request->query('sort', 'name');
        $category = $request->query('category');
        $query = MenuItems::query();

        if ($category) {
            $query->where('category', $category);
        }

        if (in_array($sortBy, ['name', 'price', 'popularity_score'])) {
            if ($sortBy === 'popularity_score') {
                $query->orderByDesc($sortBy);
            } else {
                $query->orderBy($sortBy);
            }
        }

        $menuItems = $query->get();
        $categories = MenuItems::select('category')->distinct()->pluck('category');

        return view('menu.view', compact('menuItems', 'categories'));
    }

    public function manage()
    {
        $menuItems = MenuItems::all();
        return view('menu.manage', compact('menuItems'));
    }

    public function add()
    {
        return view('menu.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'photo_url' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
            'popularity_score' => 'nullable|numeric|min:0',
        ]);

        MenuItems::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'photo_url' => $request->photo_url,
            'is_available' => $request->is_available,
            'popularity_score' => $request->popularity_score ?? 0,
        ]);

        return redirect()->route('menu.manage')->with('success', 'Menu item added successfully!');
    }

    public function edit($item_id)
    {
        $item = MenuItems::findOrFail($item_id);
        return view('menu.edit', compact('item'));
    }

    public function update(Request $request, $item_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'photo_url' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
            'popularity_score' => 'nullable|numeric|min:0',
        ]);

        $item = MenuItems::findOrFail($item_id);
        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'photo_url' => $request->photo_url,
            'is_available' => $request->is_available,
            'popularity_score' => $request->popularity_score ?? $item->popularity_score,
        ]);

        return redirect()->route('menu.manage')->with('success', 'Menu item updated successfully!');
    }

    public function delete($item_id)
    {
        $item = MenuItems::findOrFail($item_id);
        $item->delete();

        return redirect()->route('menu.manage')->with('success', 'Menu item deleted successfully!');
    }
}