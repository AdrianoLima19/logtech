<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all()
    {
        return response()->json(Product::with('brand', 'categories')->get());
    }

    public function index()
    {
        return response()->json(Product::with('brand', 'categories')->paginate(20));
    }

    public function show(Product $product)
    {
        return response()->json($product->load('brand', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product = Product::create($request->only(['name', 'description', 'price', 'stock', 'brand_id']));
        $product->categories()->sync($request->categories);

        return response()->json(['message' => 'Product created successfully', 'product' => $product->load('brand', 'categories')]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'brand_id' => 'exists:brands,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product->update($request->only(['name', 'description', 'price', 'stock', 'brand_id']));
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return response()->json(['message' => 'Product updated successfully', 'product' => $product->load('brand', 'categories')]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
