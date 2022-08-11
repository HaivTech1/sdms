<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ContestantResource extends JsonResource
{
    public static $wrap  = 'contestant';

    public function toArray($request)
    {
        return [
            'type'          => 'contestant',
            'id'            => $this->id(),
            'name'       => $this->name(),
            'email'        => $this->email(),
            'dob'        => $this->dob(),
            'state'        => $this->state(),
            'mobile'        => $this->mobile_no(),
            'height'        => $this->height(),
            'waist'        => $this->waist(),
            'excerpt'       => $this->excerpt(100),
            'description'   => $this->description(),
            
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