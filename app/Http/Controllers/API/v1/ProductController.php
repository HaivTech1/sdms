<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Http\Resources\v1\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page ?? 5;
        $limit = $request->limit ?? 5;
        return new ProductCollection(Product::searchResults()
            ->inRandomOrder()
            ->verified()
            ->available()
            ->limit($limit)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return (new ProductResource($product))
        ->response()
        ->setStatusCode(200);
    }
}