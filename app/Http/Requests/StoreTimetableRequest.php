<?php

namespace App\Http\Requests;

use App\Rules\LessonTimeAvailabilityRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimetableRequest extends FormRequest
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
            'grade_id'   => [
                'required',
                'integer'],
            'teacher_id' => [
                'required',
                'integer'],
            'weekday'    => [
                'required',
                'integer',
                'min:1',
                'max:7'],
            'start_time' => [
                'required',
                new LessonTimeAvailabilityRule(),
                // 'date_format:' . config('settings.lesson_time_format')
            ],
            'end_time'   => [
                'required',
                'after:start_time',
                // 'date_format:' . config('settings.lesson_time_format')
            ],
        ];
    }
}
