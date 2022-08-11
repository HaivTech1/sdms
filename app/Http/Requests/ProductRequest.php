<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

    public function rules()
    {
        return [
            'title'                       => ['required', 'max:100'],
            'price'                       => ['required'],
            'image'                       => ['sometimes'],
            'description'                 => ['nullable'],
            'category'                      => ['required'],
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

    public function quantity(): int
    {
        return $this->get('qty');
    }

    public function discount(): ?string
    {
        return $this->get('discount');
    }
     
    public function brand(): string
    {
        return $this->get('brand');
    }

    public function category(): string
    {
        return $this->get('category');
    }

    public function description(): ?string
    {
        return $this->get('description');
    }

    public function image(): ?array
    {
        return $this->image;
    }
}