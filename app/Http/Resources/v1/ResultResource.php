<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id(),
            'session'          => $this->period->title(),
            'term'          => $this->term->title(),
            'subject'          => $this->subject->title(),
            'grade'          => $this->grade->title(),
        ];
    }
}
