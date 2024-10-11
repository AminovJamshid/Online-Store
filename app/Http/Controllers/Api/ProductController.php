<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Order_product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
//        dd(\request()->all());
        return Order_product::query()
            ->where('category_id', request()->category_id)
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Order_product
    {
        $product              = new Order_product();
        $product->name        = $request->input('name');
        $product->description = $request->input('description');
        $product->price       = $request->input('price');
        $product->category()->associate($request->input('category'));
        $product->save();

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Order_product $product): \Illuminate\Database\Eloquent\Collection
    {
        return $product->with('category')->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order_product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Order_product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order_product $product)
    {
        //
    }
}
