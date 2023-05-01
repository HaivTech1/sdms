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
            'id'            => $this->id(),
            'name'          => $this->name(),
            'type'          => $this->user_type,
            'image'          => $this->image(),
            'has2FA'        => $this->two_factor_secret ? true : false,
        ];
    }
}