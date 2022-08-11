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
            'first_name'  => 'required|min:10',
            'last_name'     => 'required|min:10',
            'other_name'        => 'required|min:10',
            'gender'        => 'required|min:10',
            'dob'       => 'required|min:10',
            'nationality'       => 'required|min:10',
            'state_of_origin'       => 'required|min:10',
            'local_government'      => 'required|min:10',
            'address'       => 'required|min:10',
        ];
    }
}