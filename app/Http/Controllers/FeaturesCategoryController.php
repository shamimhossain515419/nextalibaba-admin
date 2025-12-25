<?php

namespace App\Http\Controllers;

use App\Models\FeaturesCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = FeaturesCategory::all();
        return view('pages.features-category.show', compact('features'));
    }
    public function indexWebView()
    {
        $features = FeaturesCategory::all();
        return response()->json([
            'success' => true,
            'message' => 'Get  features category  fetched successfully',
            'data' => $features,
        ], 200);
    }
    public function create()
    {
        return view('pages.features-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:features_categories,name',
            ]);

            FeaturesCategory::create([
                'name' => $request->name,
            ]);

            return redirect()->route('features.category.index')
                ->with('success', 'Variants added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $variant = FeaturesCategory::find($id);
        return view('pages.features-category.edit',compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = FeaturesCategory::findOrFail($id);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('features.category.index')
            ->with('success', 'Variant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = FeaturesCategory::findOrFail($id);
        $variant->delete();
        return redirect()->route('features.category.index')
            ->with('success', 'Variants deleted successfully!');

    }
}
