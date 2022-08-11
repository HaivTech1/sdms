<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\ContestantResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestResource extends JsonResource
{
    public static $wrap  = 'contest';

    public function toArray($request)
    {
        return [
            'type'          => 'contest',
            'id'                => $this->id(),
            'name'                => $this->title(),
            'theme'                => $this->theme(),
            'startDate'                => $this->startDate(),
            'endDate'                => $this->endDate(),
            'relationships'     => [
                'contestants'      => ContestantResource::collection($this->contestants()),
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