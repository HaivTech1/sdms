<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public static $wrap  = 'registrations';

    public function toArray($request)
    {
        return [
            'id'                    => $this->id(),
            'name'                  => $this->lastName() . ' ' . $this->firstName() . ' ' . $this->otherName(),
            'gender'                => $this->gender(),
            'dob'                   => $this->dob(),
            'image'                 => $this->image(),
            'prev_school'           => $this->prevSchool(),
            'prev_class'            => $this->prevClass(),
            'nationality'                => $this->nationality(),
            'stateOfOrigin'                => $this->stateOfOrigin(),
            'localGovernment'                => $this->localGovernment(),
            'address'                   => $this->address(),
            'joined_at'                => $this->createdAt(),
            'religion'                  => $this->religion,
            'denomintion'                => $this->denomintion,
            'blood_group'                => $this->blood_group,
            'medical_history'                => $this->medical_history,
            'speech_development'                => $this->speech_development,
            'sight'                     => $this->sight,
            'allergics'                 => $this->allergics,
            'grade'                     => new GradeResource($this->grade),
            'mother_info' => [
                'name' => $this->mother_name,
                'email' => $this->mother_email,
                'phone' => $this->mother_phone,
                'occupation' => $this->mother_occupation,
                'office_address' => $this->mother_office_address
            ],
            'father_info' => [
                'name' => $this->father_name,
                'email' => $this->father_email,
                'phone' => $this->father_phone,
                'occupation' => $this->father_occupation,
                'office_address' => $this->father_office_address
            ],
            'guardian_info' => [
                'name' => $this->guardian_name,
                'email' => $this->guardian_email,
                'phone' => $this->guardian_phone,
                'occupation' => $this->guardian_occupation,
                'office_address' => $this->guardian_office_address
            ],
        ];
    }
}
