<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        return Product::query()
            ->when(
                $request->category_id,
                function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })
            ->when($request->order && $request->order_by, function ($query) use ($request) {
                return $query->orderBy($request->order_by, $request->order);
            })
            ->limit($request->limit)
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
    public function store(Request $request): Product
    {
        $product              = new Product();
        $product->name        = $request->input('name');
        $product->description = $request->input('description');
        $product->price       = $request->input('price');
        $product->category()->associate($request->input('category_id'));
        $product->save();

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): \Illuminate\Database\Eloquent\Collection
    {
        return $product->with('category')->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getProductsByCategory($id)
    {
        $products = Product::query()->where('category_id', $id)
            ->with('category');


        new \App\Http\Controllers\Resources\ProductResource($products->first());

        new \App\Http\Resources\ProductCollection($products->get());
    }
}
