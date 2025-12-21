<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('pages.inventory.category.show', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // 1️⃣ Validate input
            $request->validate([
                'name' => 'required|string|max:255|unique:product_categories,name',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            // 2️⃣ Handle photo upload
            $photoPath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $photoName = uniqid('cat_', true) . '.' . $file->extension();
                $file->move(public_path('storage/images'), $photoName);
                $photoPath = 'images/' . $photoName;
            }
            // 3️⃣ Create category
             ProductCategory::create([
                'name' => $request->name,
                'image' => $photoPath,
            ]);


            // 4️⃣ Redirect with success
            return redirect()->route('inventory.category.index')
                ->with('success', 'Category added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            dd($e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function create()
    {
        return view('pages.inventory.category.create');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = ProductCategory::find($id);
        return view('pages.inventory.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = ProductCategory::findOrFail($id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/images'), $imageName);
            $category->image = 'images/' . $imageName;
        }

        $category->save();

        return redirect()->route('inventory.category.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $productCategory = ProductCategory::findOrFail($id);
            // 🔥 1️⃣ Image থাকলে ফাইল delete করো
            if ($productCategory->image) {
                $imagePath = public_path('storage/' . $productCategory->image);

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // 🔥 2️⃣ Category delete
            $productCategory->delete();

            // 🔥 3️⃣ Success redirect
            return redirect()->route('inventory.category.index')
                ->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong while deleting category!');
        }
    }

}
