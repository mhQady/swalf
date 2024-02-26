<?php

namespace App\Http\Requests\Api\Auth;

use App\Enums\User\GenderEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EnterPersonalInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gender' => ['required', Rule::in(GenderEnum::values())],
            'name' => ['string', 'required', 'min:3', 'max:255'],
            'email' => ['email', 'required', 'unique:users,email'],
            'birth_date' => ['date', 'required', 'before:today'],
            'about' => ['string', 'nullable', 'max:500'],
        ];
    }
}
