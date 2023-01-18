<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
            'title' => 'required|string|max:30',
            'content' => 'required|string',
            'grade_id' => 'required',
            'subject_id' => 'required',
        ];
    }

    public function author(): User
    {
        return $this->user();
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function content(): string
    {
        return $this->get('content');
    }

    public function grade(): string
    {
        return $this->get('grade_id');
    }

    public function subject(): string
    {
        return $this->get('subject_id');
    }
}
