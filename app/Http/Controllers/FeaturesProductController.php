<?php

namespace App\Http\Controllers;

use App\Models\FeaturesCategory;
use App\Models\FeaturesProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class FeaturesProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load product with primary image and feature category
        $features = FeaturesProduct::with('product.primaryImage', 'features_category')->get();
        return view('pages.mapping-products.show', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $features = FeaturesCategory::all();
        return view('pages.mapping-products.create', compact('products', 'features'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'features_category_id' => 'required|exists:features_categories,id',
        ]);

        // Prevent duplicate product-feature combination
        $exists = FeaturesProduct::where('product_id', $request->product_id)
            ->where('features_category_id', $request->features_category_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'This feature is already added to the product.')
                ->withInput();
        }

        FeaturesProduct::create([
            'product_id' => $request->product_id,
            'features_category_id' => $request->features_category_id,
        ]);

        return redirect()->route('mapping.product.index')
            ->with('success', 'Feature added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $featureProduct = FeaturesProduct::findOrFail($id);
        $products = Product::all();
        $features = FeaturesCategory::all();
        return view('pages.mapping-products.edit', compact('featureProduct', 'products', 'features'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'features_category_id' => 'required|exists:features_categories,id',
        ]);

        $featureProduct = FeaturesProduct::findOrFail($id);

        // Prevent duplicate update
        $exists = FeaturesProduct::where('product_id', $request->product_id)
            ->where('features_category_id', $request->features_category_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'This feature is already added to the product.')
                ->withInput();
        }

        $featureProduct->update([
            'product_id' => $request->product_id,
            'features_category_id' => $request->features_category_id,
        ]);

        return redirect()->route('mapping.product.index')
            ->with('success', 'Feature mapping updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $featureProduct = FeaturesProduct::findOrFail($id);
        $featureProduct->delete();

        return redirect()->route('mapping.product.index')
            ->with('success', 'Feature mapping deleted successfully!');
    }
}
