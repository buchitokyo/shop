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

        // Log::info($product->amount);
        // Modelオブジェクト where('product_id', $requset->product_id)->get();
        // $product = \App\Model\Product::find($requset->productId);

        $product = \App\Model\Product::find($request->productId);
        Log::info($product->quantity);
        exit;
        \Cart::add(
            $product->id,
            $product->name,
            $request->quantity,
            $product->amount
            // $request->qty,
            // ['size' => $request->size]
        );
        // [
        //     'id' => $book->id,
        //     'name' => $book->title,
        //     'qty' => '1',
        //     'price' => $book->price,
        //     'weight' => '1',
        //     'options' => ['photo_path'=> $book->photo_path]
        // ]
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
    public function destroy($id)
    {
        //
    }
}
