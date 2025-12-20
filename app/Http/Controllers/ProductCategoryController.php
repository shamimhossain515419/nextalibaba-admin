<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.inventory.category.show');
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
    public function show(ProductCategory $productCategory)
    {
        return view('pages.inventory.category.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }
}
