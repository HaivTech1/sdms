<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\GradeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                    => $this->id(),
            'title'                  => $this->title(),
            'name'                  => $this->name(),
            'email'                 => $this->email(),
            'phone_number'          => $this->phone(),
            'reg_no'                => $this->code(),
            'role'                  => $this->type,
            'type'                  => $this->user_type,
            'image'                 => $this->image(),
            'has2FA'                => $this->two_factor_secret ? true : false,
            'status'                => $this->isAvailable,
            'assigned_grades'       => GradeResource::collection($this->gradeClassTeacher)
            // 'profile'               => [
            //     'back_account' => $this->profile->ACCTN() ?? '',
            //     'account_number' => $this->profile->ACCTNO() ?? '',
            //     'salary' => $this->profile->salary() ?? '',
            // ]
        ];
    }
}
