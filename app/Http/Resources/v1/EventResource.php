<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'time' => $this->time,
            'category' => $this->category,
            'period' => [
                'id' => $this->period->id,
                'title' => $this->period->title,
            ],
            'term' => [
                'id' => $this->term->id,
                'title' => $this->term->title,
            ],
        ];
    }
}
