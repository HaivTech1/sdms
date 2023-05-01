<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id(),
            'title'          => $this->title(),
        ];
    }
}
