<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductsUpdates;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json([
            'products' => Products::where('user_id', $user->id)->get()
        ], 200);
    }

    public function new()
    {

        return response()->json([
            'products' => Products::all()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:500',
            'description' => 'required|min:3|max:2000',
            'amount' => 'required|min:0',
            'minimum' => 'required|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => trans('validation.validate_message'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        $product = Products::create([
            'user_id' => $user->id,
            'name' => $request['name'],
            'description' => $request['description'],
            'amount' => $request['amount'],
            'minimum' => $request['minimum']
        ]);

        return response()->json([
            'product' => $product
        ], 201);
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
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($product->user_id != $user->id) {
            return response()->json([
                'error' => 'Product does not belong to user'
            ], 403);
        }

        //else

        return \response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $product, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:500',
            'description' => 'required|min:3|max:2000',
            'amount' => 'required|min:0',
            'minimum' => 'required|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => trans('validation.validate_message'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if ($product->user_id != $user->id) {
            return response()->json([
                'error' => 'Product does not belong to user'
            ], 403);
        }

        //else
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->amount = $request['amount'];
        $product->minimum = $request['minimum'];
        $product->save();

        $pu = ProductsUpdates::where([['user_id', $user->id], ['product_id', $product->id]])->first();

        if ($pu == null) {
            $pu = ProductsUpdates::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
        } else {
            $pu->destroy($pu->id);
            $pu = ProductsUpdates::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
        }

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($product->user_id != $user->id) {
            return response()->json([
                'error' => 'Product does not belong to user'
            ], 403);
        }

        //else

        $product->destroy($product->id);

        return response()->json([], 204);
    }

    public function add(Products $product, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => trans('validation.validate_message'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        $product->amount = ($product->amount + $request['amount']);

        $product->save();

        $pu = ProductsUpdates::where([['user_id', $user->id], ['product_id', $product->id]])->first();

        if ($pu == null) {
            $pu = ProductsUpdates::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
        } else {
            $pu->destroy($pu->id);
            $pu = ProductsUpdates::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
        }

        return response()->json([
            'product' => $product
        ], 200);
    }

    public function rem(Products $product, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => trans('validation.validate_message'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if ($product->amount >= $request['amount']) {
            $product->amount = ($product->amount - $request['amount']);

            $product->save();

            $pu = ProductsUpdates::where([['user_id', $user->id], ['product_id', $product->id]])->first();

            if ($pu == null) {
                $pu = ProductsUpdates::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id
                ]);
            } else {
                $pu->destroy($pu->id);
                $pu = ProductsUpdates::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id
                ]);
            }

            return response()->json([
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'error' => 'invalid amount'
            ], 422);
        }
    }
}
