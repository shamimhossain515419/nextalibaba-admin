<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\MappingVariant;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\User;
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

    public function getProductByCategory(Request $request)
    {
        $slug = $request->slug;
        $productCategory= ProductCategory::where('slug', $slug)->first();
        $products = Product::with('mainTwoImages')->where('category_id', $productCategory->id)->paginate(15);
        return response()->json([
            'success' => true,
            'message' => 'Get product category wise fetched successfully',
            'data' => $products
        ], 200);
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
                return redirect()->back()
                    ->with('error', 'This variant attribute already exists for this product.')
                    ->withInput();
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

    public function variantUpdate(Request $request, $id)
    {
        $request->validate([
            'variant_id' => 'required',
            'attribute_id' => 'required',
            'product_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // ডুপ্লিকেট চেক (নিজের আইডি বাদে অন্য কোথাও একই কম্বিনেশন আছে কিনা)
            $exists = MappingVariant::where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)
                ->where('attribute_id', $request->attribute_id)
                ->where('id', '!=', $id)
                ->first();

            if ($exists) {
                return redirect()->back()
                    ->with('error', 'This combination already exists.')
                    ->withInput();
            }

            $mapping = MappingVariant::findOrFail($id);
            $mapping->update([
                'variant_id' => $request->variant_id,
                'attribute_id' => $request->attribute_id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Variant updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function getAttributesByVariant($variantId)
    {
        // তোমার Attribute টেবিলে যদি variant_id কলাম থাকে তবেই এটা কাজ করবে
        $attributes = Attribute::where('variant_id', $variantId)->get();
        return response()->json($attributes);
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
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $productImages = ProductImage::where("product_id", $id)->get();
        $categories = ProductCategory::all();
        return view('pages.inventory.product.edit', compact('product', 'productImages','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);
            $product->update([
                'name'        => $request->name,
                'slug'        => $product->slug ?? Str::slug($request->name),
                'description' => $request->description,
                'base_price'  => $request->base_price,
                'stock'       => $request->stock,
                'category_id' => $request->category_id,
                'sku'         => $request->sku,
                'has_variant' => $request->has_variant ? true : false,
                'status'      => $request->status ? true : false,
            ]);

            /** NEW IMAGES */
            if ($request->hasFile('images')) {

                // আগে থেকে primary আছে কিনা চেক
                $hasPrimary = ProductImage::where('product_id', $product->id)
                    ->where('is_primary', true)
                    ->exists();

                foreach ($request->file('images') as $index => $file) {

                    $filename = uniqid('product_', true) . '.' . $file->extension();
                    $file->move(public_path('storage/images'), $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => 'images/' . $filename,

                        'is_primary' => (!$hasPrimary && $index === 0),
                    ]);
                }
            }


            DB::commit();
            return redirect()
                ->route('inventory.product.index')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function destroyVariant($id)
    {
        try{
            $variant = MappingVariant::find($id);
            $variant->delete();
            return redirect()->back()->with('success', 'Variant deleted successfully.');
        }catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /** DELETE IMAGE */
    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);

        $path = public_path('storage/' . $image->image);
        if (File::exists($path)) {
            File::delete($path);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    /** SET PRIMARY IMAGE */
    public function setPrimary($id)
    {
        $image = ProductImage::findOrFail($id);

        // remove old primary
        ProductImage::where('product_id', $image->product_id)
            ->update(['is_primary' => false]);
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        // set new primary
        $image->update(['is_primary' => true]);


        return response()->json(['success' => true]);
    }
}
