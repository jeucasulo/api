<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Model\Product;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use Symfony\Component\HttpFoundation\Response;
// use App\Http\Requests\ProductRequest;

// app/Http/Resources/Product/ProductResource.php

class ProductController extends Controller
{


    public function __construct(){
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Product::all();
        // return ProductResource::collection(Product::all()); //shows everything from resource
        // return new ProductCollection(Product::all()); //shows everything from resource but gives an error saying the 'name' property do not exist due the "new" statement
        return ProductCollection::collection(Product::paginate(20)); //shows everything from resource //could use ::all();
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
    public function store(\App\Http\Requests\ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;

        $product->save();

        // return $request->all();
        return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED); // or just ,200); instead Response::
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // return $request->all();
        // primeiro criar a var de fillables
        // 
        $request['detail'] = $request->description;
        unset($request['description']);
        $product->update($request->all());

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
