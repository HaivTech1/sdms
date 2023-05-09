<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public static $wrap  = 'attendances';
    
    public function toArray($request)
    {
        return [
            'id'                => $this->id(),
            'date'         => $this->date(),
            'status'         => $this->status(),
            'grade'        => $this->grade->title(),
            'session'        => $this->session->title(),
            'term'        => $this->term->title(),
            'marked' => StudentResource::collection($this->students),
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
