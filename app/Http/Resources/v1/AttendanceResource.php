<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public static $wrap  = 'attendances';
    
    public function toArray($request)
    {
        return [
            'id'                => $this->id(),
            'title'         => $this->title(),
            'date'         => $this->date(),
            'status'         => $this->status(),
            'level'        => $this->level->title(),
            'session'        => $this->session->title(),
            'semester'        => $this->semester->title(),
            'marked' => UserResource::collection($this->students),
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
