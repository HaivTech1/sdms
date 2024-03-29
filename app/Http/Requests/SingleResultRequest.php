<?php

namespace App\Http\Requests;

use App\Models\User;
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
     * @return string
     */
    public function rules()
    {
        return [
            'period_id'          => ['required'],
            'term_id'              => ['required'],
            'grade_id'              => ['required'],
            'student_id'              => ['required'],
        ];
    }

    public function author(): User
    {
        return $this->user();
    }

    public function period(): string
    {
        return $this->get('period_id');
    }

    public function term(): string
    {
        return $this->get('term_id');
    }

    public function grade(): string
    {
        return $this->get('grade_id');
    }

    public function student(): string
    {
        return $this->get('student_id');
    }

    public function ca1(): ?array
    {
        return $this->get('ca1', []);
    }

    public function ca2(): ?array
    {
        return $this->get('ca2', []);
    }

    public function exam(): ?array
    {
        return $this->get('exam', []);
    }

    public function subject(): array
    {
        return $this->get('subject_id', []);
    }
}