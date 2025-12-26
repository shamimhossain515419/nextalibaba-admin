<?php

namespace App\Http\Controllers;

use App\Models\BannerProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class BannerProductController extends Controller
{
    /**
     * Display the banner product page.
     */
    public function index()
    {
        $banner = BannerProduct::with(['product','product.primaryImage', 'product.category'])->first();
        $products = Product::all();

        return view('pages.banner-product.banner', compact('banner', 'products'));
    }

    /**
     * Store or update banner product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'name'       => 'nullable|string|max:255',
        ]);

        BannerProduct::updateOrCreate(
            ['id' => BannerProduct::first()?->id],
            [
                'product_id' => $validated['product_id'],
                'name'       => $validated['name'] ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

}
