<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingleResultRequest extends FormRequest
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
            'period_id'              => ['array', 'required'],
            'period_id.*'            => ['exists:periods,id'],

            'term_id'              => ['array', 'required'],
            'term_id.*'            => ['exists:terms,id'],

            'grade_id'              => ['array', 'required'],
            'grade_id.*'            => ['exists:grades,id'],

            'student_id'              => ['array', 'required'],
            'student_id.*'            => ['exists:students,uuid'],
        ];
    }
}