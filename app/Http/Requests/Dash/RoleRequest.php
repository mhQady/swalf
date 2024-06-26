<?php

namespace App\Http\Requests\Dash;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows($this->method() === 'POST' ? 'add role' : 'edit role');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:roles,name,' . $this->role?->id,
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }

}
