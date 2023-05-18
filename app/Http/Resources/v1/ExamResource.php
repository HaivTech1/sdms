<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id(),
            'student'           => $this->student->firstName() . ' ' . $this->student->lastName() . ' ' . $this->student->otherName(),
            'session'          => $this->period->title(),
            'term'          => $this->term->title(),
            'subject'          => $this->subject->title(),
            'grade'          => $this->grade->title(),
            'ca1'           => $this->firstCA(),
            'ca2'           => $this->secondCA(),
            'ca3'        => $this->thirdCA(),
            'pr'                => $this->project(),
            'exam'    => $this->exam(),
        ];
    }
}
