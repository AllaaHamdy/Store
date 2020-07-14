<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=validator($request->all(),
            ['product_id'=>'required'
            ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
         $product=Product::find($request->product_id);
        if (!$product){
            return response()->json(['success'=> False,'data' => "Product dose't Exit"],400);
        }
        $request->merge(['order_status' => '0']);
        $order=Order::create($request->all());

        if($order['order_status']==0)
            $order['order_status']='Pending';
        elseif ($order['order_status']==1)
            $order['order_status']='Processing';
        elseif ($order['order_status']==2)
            $order['order_status']='Shipping';
        elseif ($order['order_status']==3)
            $order['order_status']='Delivered';
        elseif ($order['order_status']==4)
            $order['order_status']='Returned';

        return response()->json(['success'=> TRUE,'order' => $order,'product'=>$product],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        if (!$order){
            return response()->json(['success'=> False,'data' => "Order dose't Exit"],400);
        }
        $order_status=Order::where('id',$id)->first()['order_status'];
        if($request->order_status - $order_status > 1 || $request->order_status - $order_status < 0 || $request->order_status >=5){

            return response()->json(['success'=> False,'data' => "Order Status not valid"],400);
        }
        $update_query=Order::where('id', $id)
            ->update(['order_status' => $request->order_status]);
        if($request->order_status==0)
            $order_status='Pending';
        elseif ($request->order_status==1)
            $order_status='Processing';
        elseif ($request->order_status==2)
            $order_status='Shipping';
        elseif ($request->order_status==3)
            $order_status='Delivered';
        elseif ($request->order_status=4)
            $order_status='Returned';
        return response()->json(['success'=> TRUE,'data' => "order Status Updated Successfully",'order_status'=>$order_status],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
