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
        $this->get->first_name;
    }

    public function lastName(): string
    {
        $this->get->last_name;
    }

    public function otherName(): string
    {
        $this->get->other_name;
    }

    public function gender(): string
    {
        $this->get->gender;
    }

    public function dob(): string
    {
        $this->get->dob;
    }

    public function nationality(): string
    {
        $this->get->nationality;
    }

    public function stateOfOrigin(): string
    {
        $this->get->state_of_origin;
    }

    public function localGovernment(): string
    {
        $this->get->local_government;
    }

    public function address(): string
    {
        $this->get->address;
    }

    public function medical(): string
    {
        $this->get->medical_history;
    }

    public function allergics(): string
    {
        $this->get->allergics;
    }

    public function image(): string
    {
        $this->get->image;
    }
}