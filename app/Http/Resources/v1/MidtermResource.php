<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MidtermResource extends JsonResource
{
    public function toArray($request)
    {
        $midtermFormat = get_settings('midterm_format');

        $result = [
            'id' => $this->id(),
            'student' => $this->student->firstName() . ' ' . $this->student->lastName() . ' ' . $this->student->otherName(),
            'session' => $this->period->title(),
            'term' => $this->term->title(),
            'subject' => $this->subject->title(),
            'grade' => $this->grade->title(),
            'result' => [],
        ];

        foreach ($midtermFormat as $format) {
            $result[$format] = $this->{$format};
        }

        return $result;
    }
}
