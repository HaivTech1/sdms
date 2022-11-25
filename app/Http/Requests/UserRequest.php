<?php

namespace App\Http\Requests;

use Laravel\Jetstream\Jetstream;
use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Fortify\PasswordValidationRules;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
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
            'title' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'phone_number' => ['required'],
            'type' => ['required'],
        ];
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function name(): string
    {
        return $this->get('name');
    }

    public function email(): string
    {
        return $this->get('email');
    }

    public function phone(): string
    {
        return $this->get('phone_number');
    }

    public function password(): string
    {
        return $this->get('password');
    }

    public function type(): string
    {
        return $this->get('type');
    }

    public function image(): ?string
    {
        return $this->image;
    }
}