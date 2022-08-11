<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowResource extends JsonResource
{
    public static $wrap  = 'follow';

    public function toArray($request)
    {
        return [
            'type'          => 'follow',
            'id'                => $this->id(),
            'relationships'     => [
                'followers'      => UserResource::make($this->followers()),
                'follows'      => UserResource::make($this->follows()),
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