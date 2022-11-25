<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends FormRequest
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
            'title' => ['required', 'max:20', 'min:3'],
            'price' => ['required'],
            'grades'              => ['array', 'nullable'],
            'grades.*'            => ['exists:grades,id'],
            'term_id' => ['required'],
            'period_id' => ['required'],
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

    public function price(): int
    {
        return $this->get('price');
    }

    public function grades(): array
    {
        return $this->get('grades', []);
    }

    public function term(): int
    {
        return $this->get('term_id');
    }

    public function period(): int
    {
        return $this->get('period_id');
    }

}