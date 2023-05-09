<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class FatherResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id(),
            'name'          => $this->fullName(),
            'email'          => $this->email(),
            'phone_number'   => $this->phoneNumber(),
            'occupation'          => $this->occupation(),
            'office'   => $this->officeAddress(),
        ];
    }
}
