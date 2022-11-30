<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'description' => 'required|string|max:255',
            'grade_id' => 'required',
            'subject_id' => 'required',
            'cover' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'video' => 'required|file|mimetypes:video/mp4'
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

    public function description(): string
    {
        return $this->get('description');
    }

    public function grade(): string
    {
        return $this->get('grade_id');
    }

    public function subject(): string
    {
        return $this->get('subject_id');
    }

    public function video(): ?string
    {
        return $this->video;
    }
}
