<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    public static $wrap  = 'likes';

    public function toArray($request)
    {
        return [
            'type'          => 'like',
            'id'            => $this->id(),
            'relationships'     => [
                'author'      => UserResource::make($this->user_id),
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