<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
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
            'title'         => 'required',
            'theme'         => 'required',
            'start'         => 'required',
            'end'           => 'required',
            'budget'        => 'nullable'
        ];
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function theme(): string
    {
        return $this->get('theme');
    }

    public function start(): string
    {
        return $this->get('start');
    }

    public function end(): string
    {
        return $this->get('end');
    }

    public function budget(): ?string
    {
        return $this->get('budget');
    }
}