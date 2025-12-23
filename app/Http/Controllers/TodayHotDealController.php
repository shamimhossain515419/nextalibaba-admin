<?php

namespace App\Http\Controllers;

use App\Models\FeaturesCategory;
use App\Models\Product;
use App\Models\TodayHotDeal;
use Illuminate\Http\Request;

class TodayHotDealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayHotDeals = TodayHotDeal::with('product.primaryImage')->get();
        return view('pages.today-hot-deal.show', compact('todayHotDeals'));
    }
    public function create()
    {
        $products = Product::all();
        return view('pages.today-hot-deal.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|string|max:255|unique:today_hot_deals,product_id',
            ]);

            TodayHotDeal::create([
                'product_id' => $request->product_id ,
            ]);

            return redirect()->route('todayHotDeal.index')
                ->with('success', 'Today Hot Deal added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todayHotDeal = TodayHotDeal::find($id);
        $products = Product::all();
        return view('pages.today-hot-deal.edit',compact('todayHotDeal','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id ' => 'required|string|max:255|unique:today_hot_deals,id',
        ]);

        $category = TodayHotDeal::findOrFail($id);

        $category->product_id = $request->product_id;
        $category->save();

        return redirect()->route('todayHotDeal.index')
            ->with('success', 'Today Hot Deal updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = TodayHotDeal::findOrFail($id);
        $variant->delete();
        return redirect()->route('todayHotDeal.index')
            ->with('success', 'Today Hot Deal deleted successfully!');

    }
}
