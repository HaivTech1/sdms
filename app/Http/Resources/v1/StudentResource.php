<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\ClubResource;
use App\Http\Resources\v1\GradeResource;
use App\Http\Resources\v1\HouseResource;
use App\Http\Resources\v1\FatherResource;
use App\Http\Resources\v1\MotherResource;
use App\Http\Resources\v1\PaymentResource;
use App\Http\Resources\v1\SubjectResource;
use App\Http\Resources\v1\GuardianResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public static $wrap  = 'students';

    public function toArray($request)
    {
        return [
            'id'                => $this->id(),
            'name'         => $this->lastName() . ' ' . $this->firstName() . ' ' . $this->otherName(),
            'reg_no'                => $this->user->code(),
            'gender'                => $this->gender(),
            'dob'                => $this->dob(),
            'image'                 => $this->image(),
            'nationality'                => $this->nationality(),
            'stateOfOrigin'                => $this->stateOfOrigin(),
            'localGovernment'                => $this->localGovernment(),
            'address'                => $this->address(),
            'joined_at'                => $this->createdAt(),
            'grade' => new GradeResource($this->grade),
            'house' => new HouseResource($this->house),
            'club' => new ClubResource($this->club),
            'mother_info' => new MotherResource($this->mother),
            'father_info' => new FatherResource($this->father),
            'guardian_info' => new GuardianResource($this->guardian),
            'subjects' => SubjectResource::collection($this->subjects),
            'payments' => PaymentResource::collection($this->payments),
        ];
    }
}
