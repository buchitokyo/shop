<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'items' => \Cart::content(), // カートの中身
            'subtotal' => \Cart::subtotal(), // 全体の小計
            'tax' => \Cart::tax(), // 全体の税
            'total' => \Cart::total() // 全合計
        ];
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

        // Log::info($request->amount);
        // Modelオブジェクト where('product_id', $requset->product_id)->get();
        $product = \App\Model\Product::find($request->productId);

        \Cart::add(
            [
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->qty,
                'price' => $product->amount,
                'weight' => '0',
                'options' => ['size'=> $request->size]
            ]
        );

        // $product->id,
        // $product->name,
        // $request->quantity,
        // $product->amount,
        // $request->qty,
        // ['size' => $request->size]
        return \Cart::content();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return \Cart::remove($request->row_id);
    }
}
