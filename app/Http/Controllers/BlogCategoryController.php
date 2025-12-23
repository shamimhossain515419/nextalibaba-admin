<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::all();
        return view('pages.blog-category.show', compact('categories'));
    }
    public function create()
    {
        return view('pages.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:blog_categories,name',
            ]);

            BlogCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('blogCategory.index')
                ->with('success', 'Blog Category added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = BlogCategory::find($id);
        return view('pages.blog-category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = BlogCategory::findOrFail($id);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('blogCategory.index')
            ->with('success', 'Blog category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = BlogCategory::findOrFail($id);
        $variant->delete();
        return redirect()->route('blogCategory.index')
            ->with('success', 'Blog category deleted successfully!');

    }
}
