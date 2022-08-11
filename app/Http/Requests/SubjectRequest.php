<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'title'             => ['required', 'max:100'],
            'grades'              => ['array', 'nullable'],
            'grades.*'            => ['exists:grades,id'],
        ];
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function grades(): array
    {
        return $this->get('grades', []);
    }
}
