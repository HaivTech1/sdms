<?php

namespace App\Http\Resources\v1;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id(),
            'reg_no' => $this->reg_no,
            'title' => $this->title(),
            'name' => $this->name(),
            'email' => $this->email(),
            'role' => $this->type,
            'type' => $this->user_type,
            'image' => $this->image(),
            'phone_number' => $this->phone(),
            'has2FA' => $this->two_factor_secret ? true : false,
            'status' => $this->isAvailable
        ];
    }
}