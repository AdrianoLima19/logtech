<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all()
    {
        return response()->json(Category::all());
    }

    public function index()
    {
        return response()->json(Category::paginate(20));
    }

    public function show(Category $category)
    {
        return response()->json($category->load('products.categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($data);

        return response()->json(['message' => 'Category created successfully', 'category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($data);

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
