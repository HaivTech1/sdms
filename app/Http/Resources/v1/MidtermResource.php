<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MidtermResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id(),
            'student'           => $this->student->firstName() . ' ' . $this->student->lastName() . ' ' . $this->student->otherName(),
            'session'           => $this->period->title(),
            'term'              => $this->term->title(),
            'subject'           => $this->subject->title(),
            'grade'             => $this->grade->title(),
            'entry_1'           => $this->entry1(),
            'entry_2'           => $this->entry2(),
            'first_test'        => $this->firstTest(),
            'ca'                => $this->ca(),
            'class_activity'    => $this->classActivity(),
            'project'           => $this->project(),
        ];
    }
}
