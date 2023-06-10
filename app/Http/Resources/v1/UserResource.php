<?php

namespace App\Http\Resources\v1;

use App\Models\Grade;
use App\Http\Resources\v1\GradeResource;
use App\Http\Resources\v1\PointResource;
use App\Http\Resources\v1\FollowResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id(),
            'title'         => $this->title(),
            'name'          => $this->name(),
            'email'          => $this->email(),
            'role'          => $this->type,
            'type'          => $this->user_type,
            'image'          => $this->image(),
            'phone_number'          => $this->phone(),
            'has2FA'        => $this->two_factor_secret ? true : false,
            'status'        => $this->isAvailable
        ];
    }
}