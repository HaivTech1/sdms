<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'  => 'required|min:3',
            'last_name'     => 'required|min:3',
            'other_name'        => 'required|min:3',
            'gender'        => 'required',
            'dob'       => 'required',
            'nationality'       => 'required',
            'state_of_origin'       => 'required',
            'local_government'      => 'required',
            'address'       => 'required',
            'grade_id'       => 'required',
        ];
    }

    public function firstName(): string
    {
        return $this->get('first_name');
    }

    public function lastName(): string
    {
        return $this->get('last_name');
    }

    public function otherName(): string
    {
        return $this->get('other_name');
    }

    public function gender(): string
    {
        return $this->get('gender');
    }

    public function dob(): string
    {
        return $this->get('dob');
    }

    public function nationality(): string
    {
        return $this->get('nationality');
    }

    public function stateOfOrigin(): string
    {
        return $this->get('state_of_origin');
    }

    public function localGovernment(): string
    {
        return $this->get('local_government');
    }

    public function address(): string
    {
        return $this->get('address');
    }

    public function prevSchool(): ?string
    {
        return $this->get('prev_school');
    }

    public function prevClass(): ?string
    {
        return $this->get('prev_class');
    }

    public function medical(): string
    {
        return $this->get('medical_history');
    }

    public function allergics(): string
    {
        return $this->get('allergics');
    }

    public function image(): ?string
    {
        return $this->image;
    }

    public function grade(): string
    {
        return $this->get('grade_id');
    }
    
    public function fullName(): string
    {
        return $this->get('full_name');
    }

    public function email(): string
    {
        return $this->get('email');
    }

    public function phoneNumber(): string
    {
        return $this->get('phone_number');
    }

    public function occupation(): string
    {
        return $this->get('occupation');
    }

    public function officeAddress(): string
    {
        return $this->get('office_address');
    }

    public function homeAddress(): string
    {
        return $this->get('home_address');
    }

    public function relationship(): string
    {
        return $this->get('relationship');
    }
}