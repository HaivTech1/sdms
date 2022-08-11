<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestantRequest extends FormRequest
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
            'name'                              => ['required', 'max:100'],
            'email'                             => ['required'],
            'description'                       => ['nullable'],
            'mobile_no'                         => ['required'],
            'state'                             => ['required'],
            'dob'                               => ['required'],
            'image'                             => ['nullable', 'max:2048'],
        ];
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function mobile_no(): ?string
    {
        return $this->mobile_no;
    }

    public function state(): ?string
    {
        return $this->state;
    }

    public function dob(): ?string
    {
        return $this->dob;
    }

    public function height(): ?string
    {
        return $this->height;
    }

    public function waist(): ?string
    {
        return $this->waist;
    }

    public function description(): ?string
    {
        return $this->description;
    }
    
    public function image(): array
    {
        return $this->image;
    }
}