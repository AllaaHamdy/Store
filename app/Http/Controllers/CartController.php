<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add_order(Request $request,$order_id)
    {
        $final_price = 0;
        $order = Order::find($order_id);
        if (!$order) {
            return response()->json(['success' => False, 'data' => "Order dose't Exit"], 400);
        }
        if ($request->ShippingMethod != 'home'){
            if ($request->ShippingMethod != 'pickup') {
                return response()->json(['success' => False, 'data' => "Shipping Method must be home or pickup only"], 400);
            }
        }
        if($request->PaymentMethod !='cach') {
            if ($request->PaymentMethod != 'visa') {
                return response()->json(['success' => False, 'data' => "Payment Method must be cash or visa only"], 400);
            }
        }
        $product_price= Product::find($order->product_id)['price'];
       $product_name=Product::find($order->product_id)['title'];

        //add taxes 10%
        $final_price=$product_price*(1+0.10);
        // add 5% cost for home shipping
        if($request->ShippingMethod == 'home'){
            $final_price=$final_price*(1+0.05);
        }
        //add copon discount to price
        if($request-> CouponCode== 'A3000'){
            $final_price=$final_price*(1-0.10);
        }
        $order_data= $request->merge(['price'=>$product_price,'final_price' => $final_price,'product_name'=>$product_name])->all();
            return response()->json(['success'=> TRUE,'message' => "Order added to cart successfully",'order'=>$order_data],400);



    }
}
