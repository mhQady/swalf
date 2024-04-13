<?php

namespace App\Http\Requests\Dash;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class InterestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $check = $this->method() === 'POST' ? 'add interest' : 'edit interest';

        return Gate::allows($check);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name.ar' => 'required|string|min:3|max:255',
        ];
    }
}
