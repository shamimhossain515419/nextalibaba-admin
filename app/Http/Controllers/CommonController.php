<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Disclaimer;
use App\Models\Packaging;
use App\Models\PrivacyPolicy;
use App\Models\ReturnRefund;
use App\Models\ShippingPolicy;
use App\Models\TermsConditions;
use Illuminate\Http\Request;

class CommonController extends Controller
{

    public function indexDisclaimer()
    {
        $data = Disclaimer::first();
        return view('pages.disclaimer.index', compact('data'));
    }
    public function disclaimer()
    {
        try{
            $about = Disclaimer::first();
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
    public function storeDisclaimer(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $data = Disclaimer::first();

        if($data){
            $data->update($validated);
            return back()->with('success','updated successfully');
        } else {
            Disclaimer::create($validated);
            return back()->with('success','created successfully');
        }
    }


  //    packaging
    public function indexPackaging()
    {
        $data = Packaging::first();
        return view('pages.packaging.index', compact('data'));
    }
    public function packaging()
    {
        try{
            $about = Packaging::first();
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
    public function storePackaging(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $data = Packaging::first();

        if($data){
            $data->update($validated);
            return back()->with('success','updated successfully');
        } else {
            Packaging::create($validated);
            return back()->with('success','created successfully');
        }
    }


    //    term and conditions
    public function indexConditions()
    {
        $data = TermsConditions::first();
        return view('pages.terms-conditions.index', compact('data'));
    }
    public function conditions()
    {
        try{
            $about = TermsConditions::first();
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
    public function storeConditions(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $data = TermsConditions::first();

        if($data){
            $data->update($validated);
            return back()->with('success','updated successfully');
        } else {
            TermsConditions::create($validated);
            return back()->with('success','created successfully');
        }
    }


    //    term and conditions
    public function indexShippingPolicy()
    {
        $data = ShippingPolicy::first();
        return view('pages.shipping-policy.index', compact('data'));
    }
    public function shippingPolicy()
    {
        try{
            $about = ShippingPolicy::first();
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
    public function storeShippingPolicy(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $data = ShippingPolicy::first();

        if($data){
            $data->update($validated);
            return back()->with('success','updated successfully');
        } else {
            ShippingPolicy::create($validated);
            return back()->with('success','created successfully');
        }
    }




    //  privacy policy
    public function indexPrivacyPolicy()
    {
        $data = PrivacyPolicy::first();
        return view('pages.privacy-policy.index', compact('data'));
    }
    public function privacyPolicy()
    {
        try{
            $about = PrivacyPolicy::first();
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
    public function storePrivacyPolicy(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $data = PrivacyPolicy::first();

        if($data){
            $data->update($validated);
            return back()->with('success','updated successfully');
        } else {
            PrivacyPolicy::create($validated);
            return back()->with('success','created successfully');
        }
    }


    //  returnAndRefund
    public function indexReturnAndRefund()
    {
        $data = ReturnRefund::first();
        return view('pages.return-and-refund.index', compact('data'));
    }
    public function privacyReturnAndRefund()
    {
        try{
            $about = ReturnRefund::first();
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
    public function storeReturnAndRefund(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $data = ReturnRefund::first();

        if($data){
            $data->update($validated);
            return back()->with('success','updated successfully');
        } else {
            ReturnRefund::create($validated);
            return back()->with('success','created successfully');
        }
    }





}
