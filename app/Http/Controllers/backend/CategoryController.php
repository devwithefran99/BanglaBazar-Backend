<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')->orderBy('id')->get();
        return view('backend.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:categories,name',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'image'      => $imagePath,
            'is_active'  => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('backend.categories.index')
                         ->with('success', 'Category successfully added!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            // পুরনো image delete
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'image'      => $imagePath,
            'is_active'  => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('backend.categories.index')
                         ->with('success', 'Category updated!');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->route('backend.categories.index')
                         ->with('success', 'Category deleted!');
    }
}