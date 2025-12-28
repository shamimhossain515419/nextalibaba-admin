<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\OrderLog;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();

        try {

            // ✅ 1. Validate request
            $request->validate([
                'full_name'       => 'required|string|max:255',
                'email'           => 'required|email',
                'phone'           => 'required|string',
                'country'         => 'required|string',
                'address'         => 'required|string',
                'city'            => 'required|string',
                'payment_method'  => 'required|string',
                'products'        => 'required|array',
                'products.*.id'   => 'required|integer',
                'products.*.quantities' => 'required|integer|min:1',
            ]);

            $user = User::where('email', $request->email)->first();
            if(!$user) {
                // ✅ 2. Create or get user
                $user = User::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name'     => $request->full_name,
                        'password' => Hash::make($request->password ?? '12345678'),
                    ]
                );
            }

            ShippingAddress::where('customer_id', $user->id)->delete();

            // ✅ 3. Shipping address
            $address = ShippingAddress::create([
                'full_name'   => $request->full_name,
                'company'     => $request->company,
                'country'     => $request->country,
                'address'     => $request->address,
                'city'        => $request->city,
                'state'       => $request->state,
                'zip'         => $request->zip,
                'phone'       => $request->phone,
                'email'       => $request->email,
                'customer_id' => $user->id,
            ]);

            // ✅ 4. Order create
            $order = Order::create([
                'quantity'        => $request->total_quantity,
                'total'           => $request->total,
                'invoice'        => Str::uuid(),
                'shipping_cost'   => $request->shipping_cost,
                'notes'           => $request->notes,
                'payment_method'  => $request->payment_method,
                'customer_id'     => $user->id,
            ]);

            // ✅ 5. Order items (OrderLog)
            foreach ($request->products as $product) {
                $note = '';
                if (!empty($product['variantInfo']) && is_array($product['variantInfo'])) {
                    foreach ($product['variantInfo'] as $item) {
                        $note .= $item['variant_name'] . ' : ' . $item['attribute_name'] . ', ';
                    }
                    $note = rtrim($note, ', ');
                }
                OrderLog::create([
                    'order_id'   => $order->id,
                    'product_id' => $product['id'],
                    'quantity'   => $product['quantities'],
                    'total'      => (float)$product['base_price'] * (int)$product['quantities'],
                    'notes'      => $note,
                ]);
            }

            DB::commit();

            // ✅ 6. Correct success response
            return response()->json([
                'success'  => true,
                'message'  => 'Order created successfully',
                'order'    => $order,
                'address'  => $address,
                'customer' => $user,
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function invoice($invoice)
    {
        try{
            $order = Order::where('invoice', $invoice)->first();
            $orderLogs = OrderLog::with('product')->where('order_id', $order->id)->get();
            $user= User::find($order->customer_id);
            $shipping_address = ShippingAddress::where('customer_id', $user->id)->first();
             return response()->json([
                 'success'  => true,
                 'order'    => $order,
                 'orderLogs' => $orderLogs,
                  'user'     => $user,
                 'shipping_address' => $shipping_address
             ]);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function myAllOrders(Request $request)
    {
        try{
            $user =  $request->user();
            $order = Order::where('customer_id', $user->id)->get();
            return response()->json([
                'success'  => true,
                'order'    => $order,
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
