<?php

namespace App\Http\Requests\Dash;

use App\Models\State;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $check = $this->method() === 'POST' ? 'add city' : 'edit city';

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
            'name' => 'required|string|min:3|max:255|unique:cities,name,' . $this->city?->id,
            'country_id' => 'required|integer|exists:countries,id',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['state_id' => State::where('country_id', $this->country_id)->first()?->id]);
    }
}
