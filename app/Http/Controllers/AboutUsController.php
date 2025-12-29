<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = AboutUs::first();
        return view('pages.about-us.index', compact('about'));
    }

    public function about()
    {
        try{
            $about = AboutUs::first();
            return response()->json([
                'success'  => true,
                'data'    => $about,
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store or update banner product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'support_email' => 'nullable|email',
            'about_info' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif,webp|max:2048',
            'navbar_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,webp|max:1024',
        ]);

        $about = AboutUs::first();

        // Handle images
        foreach(['footer_logo','navbar_logo','favicon'] as $imgField){
            if($request->hasFile($imgField)){
                $file = $request->file($imgField);
                $filename = uniqid($imgField.'_').'.'.$file->extension();
                $file->move(public_path('storage/images'), $filename);
                $validated[$imgField] = $filename;
            }
        }

        if($about){
            $about->update($validated);
            return back()->with('success','About info updated successfully');
        } else {
            AboutUs::create($validated);
            return back()->with('success','About info created successfully');
        }
    }


}
