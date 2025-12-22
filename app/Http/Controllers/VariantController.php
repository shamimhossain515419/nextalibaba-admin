<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $variants = Variant::all();
         return view('pages.variants.show', compact('variants'));
    }
    public function create()
    {
        return view('pages.variants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:variants,name',
            ]);

            Variant::create([
                'name' => $request->name,
            ]);

            return redirect()->route('variants.index')
                ->with('success', 'Variants added successfully!');

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
        $variant = Variant::find($id);
        return view('pages.variants.edit',compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Variant::findOrFail($id);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('variants.index')
            ->with('success', 'Variant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);
        $variant->delete();
        return redirect()->route('variants.index')
            ->with('success', 'Variants deleted successfully!');

    }
}
