<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category','primaryImage']);

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Apply pagination
        $products = $query->paginate(15); // Default is 15 items per page

        // Preserve search term in pagination links
        if ($request->has('search')) {
            $products->appends(['search' => $request->search]);
        }

        return view('pages.inventory.product.show', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('pages.inventory.product.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = auth()->user();
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'description' => $request->description,
                'base_price' => $request->base_price,
                'category_id' => $request->category_id,
                'sku' => $request->sku,
                'has_variant' => $request->variants=='on' ? true : false,
                'status' => $request->status=='on' ? true : false,
                'added_by' => $user->id,
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images'), $filename);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'images/'.$filename,
                    'is_primary' => true,
                ]);
            }

            DB::commit();
            return redirect()->route('inventory.product.index')
                ->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
