<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductsUpdates;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductsUpdatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $pu = ProductsUpdates::where('products_updates.user_id', $user->id)
        ->join('products', 'products_updates.product_id', '=', 'products.id')
        ->select('products.*')
        ->orderBy('products_updates.id', 'desc')
        ->get();

        $productsToBeReplaced = Products::where([ ['user_id', $user->id], ['amount', '<', DB::raw('minimum')] ])->get();

        return response()->json([
            'productsUpdates' => $pu,
            'productsToBeReplaced' => $productsToBeReplaced
        ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsUpdates  $productsUpdates
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsUpdates $productsUpdates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsUpdates  $productsUpdates
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductsUpdates $productsUpdates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsUpdates  $productsUpdates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductsUpdates $productsUpdates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsUpdates  $productsUpdates
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsUpdates $productsUpdates)
    {
        //
    }
}
