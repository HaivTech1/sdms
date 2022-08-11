<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultRequest extends FormRequest
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
            'period_id' => 'required',
            'term_id' => 'required',
            'grade_id' => 'required',
            'student_id' => 'required',
        ];
    }

    public function ca1(): ?array
    {
        return $this->get('ca1', []);
    }

    public function ca2(): ?array
    {
        return $this->get('ca2', []);
    }

    public function ca3(): ?array
    {
        return $this->get('ca3', []);
    }

    public function exam(): ?array
    {
        return $this->get('exam', []);
    }

    public function period(): array
    {
        return $this->get('period_id', []);
    }

    public function term(): array
    {
        return $this->get('term_id', []);
    }
}