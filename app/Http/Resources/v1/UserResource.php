<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\PointResource;
use App\Http\Resources\v1\FollowResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type'          => 'user',
            'id'            => $this->id(),
            'name'          => $this->name(),
            'type'          => $this->type(),
            'image'          => $this->image(),
            'has2FA'        => $this->two_factor_secret ? true : false,
            'rank'          => $this->rank(),
            'point'          => $this->currentPoints(),
            // 'relationships'         => [
            //     'followship'           =>  FollowResource::collection($this->follows()),
            // ],
        ];
    }
}