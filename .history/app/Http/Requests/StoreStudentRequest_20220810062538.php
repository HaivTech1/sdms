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
        ];
    }

    public function firstName(): string
    {
        $this->get('photo_credit_text');
    }

    public function lastName(): string
    {
        return $this->last_name;
    }

    public function otherName(): string
    {
        return $this->other_name;
    }

    public function gender(): string
    {
        return $this->gender;
    }

    public function dob(): string
    {
        return $this->dob;
    }

    public function nationality(): string
    {
        return $this->nationality;
    }

    public function stateOfOrigin(): string
    {
        return $this->state_of_origin;
    }

    public function localGovernment(): string
    {
        return $this->local_government;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function medical(): string
    {
        return $this->medical_history;
    }

    public function allergics(): string
    {
        return $this->allergics;
    }

    public function image(): string
    {
        return $this->image;
    }
}