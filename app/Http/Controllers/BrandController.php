<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function all()
    {
        return response()->json(Brand::all());
    }

    public function index()
    {
        return response()->json(Brand::paginate(20));
    }

    public function show(Brand $brand)
    {
        return response()->json($brand->load('products.categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = Brand::create($data);

        return response()->json(['message' => 'Brand created successfully', 'brand' => $brand]);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand->update($data);

        return response()->json(['message' => 'Brand updated successfully', 'brand' => $brand]);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json(['message' => 'Brand deleted successfully']);
    }
}
