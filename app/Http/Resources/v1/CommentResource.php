<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\AuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public static $wrap  = 'comment';

    public function toArray($request)
    {
        return [
            'type'          => 'comment',
            // 'id'            => $this->id(),
            'excerpt'        => $this->excerpt(),
            'description'       => $this->description(),
            'relationships'     => [
                'author'      => AuthorResource::make($this->author()),
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