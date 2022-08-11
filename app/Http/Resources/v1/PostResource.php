<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\TagResource;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap  = 'posts';
    
    public function toArray($request)
    {
        return [
            'type'              => 'posts',
            'id'                => $this->id(),
            'attribute'         => [
                'title'         => $this->title(),
                'slug'          => $this->slug(),
                'excerpt'       => $this->excerpt(100),
                'description'   => $this->description(),
                'image'         => $this->image(),
                'createdAt'     => $this->created_date,
                'type'          => $this->type(),
                'readTime'          => $this->readTime(),
                'PhotoCreditText'          => $this->PhotoCreditText(),
                'photoCreditLink'          => $this->photoCreditLink(),

            ],
            'relationships'     => [
                'author'        => UserResource::make($this->author()),
                'tags'          => TagResource::collection($this->tags()),
                'likes'         => LikeResource::collection($this->likes()),
                'comments'      => CommentResource::collection($this->comments()),
            ]
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