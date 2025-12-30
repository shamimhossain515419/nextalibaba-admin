<?php

namespace App\Http\Controllers;

use App\Models\MarketingProduct;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MarketingProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = MarketingProduct::with('category')->get();
        return view('pages.marketing-product.show', compact('products'));
    }
    public function indexWebView()
    {
        $categories = MarketingProduct::with('category')->get();

        return response()->json([
            'success' => true,
            'message' => 'Marketing product fetched successfully',
            'data' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // 1️⃣ Validate input
            $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'category_id' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            ]);

            // 2️⃣ Handle photo upload
            $photoPath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $photoName = uniqid('mp_', true) . '.' . $file->extension();
                $file->move(public_path('storage/images'), $photoName);
                $photoPath = 'images/' . $photoName;
            }
            // 3️⃣ Create category
            MarketingProduct::create([
                'name' => $request->name,
                'title' => $request->title,
                'category_id' => $request->category_id,
                'image' => $photoPath,
            ]);

            // 4️⃣ Redirect with success
            return redirect()->route('marketingProduct.index')
                ->with('success', 'Marketing added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function create()
    {
        $categories= ProductCategory::all();
        return view('pages.marketing-product.create', compact('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = ProductCategory::all();
        $product = MarketingProduct::with('category')->find($id);
        return view('pages.marketing-product.edit',compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'category_id' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ]);

        $marketingProduct = MarketingProduct::findOrFail($id);

        $marketingProduct->name = $request->name;
        $marketingProduct->title = $request->title;
        $marketingProduct->category_id = $request->category_id;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($marketingProduct->image && file_exists(public_path($marketingProduct->image))) {
                unlink(public_path($marketingProduct->image));
            }
            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/images'), $imageName);
            $marketingProduct->image = 'images/' . $imageName;
        }

        $marketingProduct->save();

        return redirect()->route('marketingProduct.index')
            ->with('success', 'Marketing Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $productCategory = MarketingProduct::findOrFail($id);
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
            return redirect()->route('marketingProduct.index')
                ->with('success', 'Marketing deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong while deleting category!');
        }
    }
}
