<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::orderBy('name')->get();
        return response()->json(['data' => $categories]);
    }

    public function show($id): JsonResponse
    {
        // Accept ID or Slug
        if (is_numeric($id)) {
            $category = Category::with('products')->find($id);
        } else {
            $category = Category::with('products')->where('slug', $id)->first();
        }

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['data' => $category]);
    }

    // Admin CRUD Operations

    public function store(Request $request): JsonResponse
    {
        // Ensure user is admin (simple check matches web routes)
        if ($request->user()->name !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        $category = Category::create($validated);

        return response()->json(['data' => $category, 'message' => 'Category created'], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        if ($request->user()->name !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
        ]);

        $category->update($validated);

        return response()->json(['data' => $category, 'message' => 'Category updated']);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        if ($request->user()->name !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
