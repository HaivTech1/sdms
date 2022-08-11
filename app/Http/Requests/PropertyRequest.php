<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'title'                             => ['required', 'max:50'],
            'price'                             => ['required'],
            'purpose'                           => ['required'],
            'frequency'                         => ['required'],
            'built'                             => ['required'],
            'category'                            => ['required'],
            'address'                           => ['required'],
            'description'                       => ['required'],
            'image'                             => ['nullable', 'max:2048'],
            'video'                             => ['nullable'],
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

    public function price(): string
    {
        return $this->get('price');
    }
    
    public function built(): ?string
    {
        return $this->get('built');
    }

    public function bedroom(): ?string
    {
        return $this->get('bedroom');
    }

    public function bathroom(): ?string
    {
        return $this->get('bathroom');
    }

    public function category(): ?string
    {
        return $this->get('category');
    }

    public function purpose(): ?string
    {
        return $this->get('purpose');
    }

    public function address(): ?string
    {
        return $this->get('address');
    }
    
    public function latitude(): ?string
    {
        return $this->get('latitude');
    }

    public function longitude(): ?string
    {
        return $this->get('longitude');
    }

    public function frequency(): ?string
    {
        return $this->get('frequency');
    }

    public function description(): string
    {
        return $this->get('description');
    }

    public function furnish(): bool
    {
        return $this->boolean('furnish');
    }

    public function fence(): bool
    {
        return $this->boolean('fence');
    }

    public function wifi(): bool
    {
        return $this->boolean('wifi');
    }

    public function park(): bool
    {
        return $this->boolean('park');
    }

    public function conditioning(): bool
    {
        return $this->boolean('conditioning');
    }

    public function pool(): bool
    {
        return $this->boolean('pool');
    }


    public function tiles (): bool
    {
        return $this->boolean('tiles ');
    }

    public function image(): ?array
    {
        return $this->image;
    }

    public function video(): ?string
    {
        return $this->video;
    }
}