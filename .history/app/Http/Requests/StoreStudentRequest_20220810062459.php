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
        return (string) $this->first_name;
    }

    public function lastName(): string
    {
        return (string) $this->last_name;
    }

    public function otherName(): string
    {
        return (string) $this->other_name;
    }

    public function gender(): string
    {
        return (string) $this->gender;
    }

    public function dob(): string
    {
        return (string) $this->dob;
    }

    public function nationality(): string
    {
        return (string) $this->nationality;
    }

    public function stateOfOrigin(): string
    {
        return (string) $this->state_of_origin;
    }

    public function localGovernment(): string
    {
        return (string) $this->local_government;
    }

    public function address(): string
    {
        return (string) $this->address;
    }

    public function medical(): string
    {
        return (string) $this->medical_history;
    }

    public function allergics(): string
    {
        return (string) $this->allergics;
    }

    public function image(): string
    {
        return (string) $this->image;
    }
}