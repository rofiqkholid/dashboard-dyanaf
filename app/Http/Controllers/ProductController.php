<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('tag', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('order')->get();

        return view('products.products', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug',
            'icon' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'tag_color' => 'nullable|string|max:7',
            'estimation' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_display' => 'nullable|string|max:255',
            'price_unit' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Service::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'icon' => $request->icon,
            'tag' => $request->tag,
            'tag_color' => $request->tag_color,
            'estimation' => $request->estimation,
            'price' => $request->price,
            'price_display' => $request->price_display,
            'price_unit' => $request->price_unit,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Service $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Service $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug,' . $product->id,
            'icon' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'tag_color' => 'nullable|string|max:7',
            'estimation' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_display' => 'nullable|string|max:255',
            'price_unit' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'icon' => $request->icon,
            'tag' => $request->tag,
            'tag_color' => $request->tag_color,
            'estimation' => $request->estimation,
            'price' => $request->price,
            'price_display' => $request->price_display,
            'price_unit' => $request->price_unit,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Service $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
