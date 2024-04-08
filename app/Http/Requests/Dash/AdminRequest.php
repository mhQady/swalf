<?php

namespace App\Http\Requests\Dash;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('add admin');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:admins,email,' . $this->admin?->id,
            'password' => [
                Rule::requiredIf(fn() => $this->method() === 'POST'),
                'confirmed',
            ],
            'roles' => 'required|array',
            'roles.*' => 'integer|exists:roles,id',
        ];
    }
}
