<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type'          => 'author',
            'id'            => $this->id(),
            'name'          => $this->name(),
            'image'         => $this->image(),
        ];
    }
}