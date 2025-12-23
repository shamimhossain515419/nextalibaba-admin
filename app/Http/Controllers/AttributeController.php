<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Variant;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::with('variant')->get();
        return view('pages.attributes.show', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $variants = Variant::all();
        return view('pages.attributes.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'variant_id' => 'required|exists:variants,id',
        ]);

        $existing =  Attribute::where("name", $request->name)->where("variant_id",$request->variant_id)->first();
        if($existing){
            return redirect()->route('attributes.create')->with('error', 'Attribute already exists.');
        }



        Attribute::create([
            'name'       => $request->name,
            'variant_id' => $request->variant_id,
        ]);

        return redirect()->route('attributes.index')
            ->with('success', 'Attribute added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $variants = Variant::all();
         $attribute = Attribute::findOrFail($id);
        return view('pages.attributes.edit', compact('attribute','variants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'variant_id' => 'required|exists:variants,id',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->update([
            'name'       => $request->name,
            'variant_id' => $request->variant_id,
        ]);

        return redirect()->route('attributes.index')
            ->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attributes.index')
            ->with('success', 'Attribute deleted successfully!');
    }
}
