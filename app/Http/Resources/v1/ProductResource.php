<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\AuthorResource;
use App\Http\Resources\v1\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap  = 'products';

    public function toArray($request)
    {
        return [
            'type'              => 'products',
            'id'                => $this->id(),
            'attribute'         => [
                'title'         => $this->title(),
                'slug'          => $this->slug(),
                'price'         => $this->price(),
                'brand'         => $this->brand(),
                'quantity'         => $this->quantity(),
                'discount'         => $this->discount(),
                'excerpt'       => $this->excerpt(100),
                'description'   => $this->description(),
                'image'         => $this->image(),

            ],
            'relationships'     => [
                'author'        => AuthorResource::make($this->author()),
                'category'      => CategoryResource::make($this->category),
            ],
            'links'             => [
                'self'          => route('products.show', $this->id()),
                'related'       => route('products.show', $this->slug())   
            ],
        ];
    }
    
    public function with($request)
    {
        return [
            'status'    => 'success',  
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Accept', 'application/json');
    }
}