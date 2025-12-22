<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\MappingVariant;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Variant;
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
        $variants = Variant::all();
        $attributes = Attribute::all();
        return view('pages.inventory.product.create', compact('categories','variants','attributes'));
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
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'sku' => $request->sku,
                'has_variant' => $request->variants=='on' ? true : false,
                'status' => $request->status=='on' ? true : false,
                'added_by' => $user->id,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {

                    $filename = uniqid('product_', true) . '.' . $file->extension();
                    $file->move(public_path('storage/images'), $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'images/' . $filename,
                        'is_primary' => $index === 0, // first image primary
                    ]);
                }
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


    public function variantStore(Request $request)
    {
        DB::beginTransaction();
        try {

            // Check if the variant mapping already exists
            $exists = MappingVariant::where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)
                ->where('attribute_id', $request->attribute_id)
                ->first();

            if ($exists) {
                return redirect()->back()->with('error', 'This variant attribute already exists for this product.');
            }
            // If not exists, create new record
            MappingVariant::create([
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'attribute_id' => $request->attribute_id,
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Variant added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function variant($id)
    {
        // Find the product, if not found, redirect back with error
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Fetch all variants and attributes
        $variants = Variant::all();
        $attributes = Attribute::all();

        // Fetch mappings for this product with related variant and attribute
        $mappings = MappingVariant::with(['variant', 'attribute'])
            ->where('product_id', $id)
            ->get();

        $product_id = $id;
        // Return view with all data
        return view('pages.inventory.product.variant', compact('product_id', 'mappings', 'variants', 'attributes'));
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
