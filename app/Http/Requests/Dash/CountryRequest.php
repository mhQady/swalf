<?php

namespace App\Http\Requests\Dash;

use App\Enums\Country\HasMarketEnum;
use Illuminate\Validation\Rule;
use App\Enums\Country\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|unique:countries,name,' . $this->country?->id,
            'code' => 'required|string|min:2|max:5|unique:countries,code,' . $this->country?->id,
            'phone_code' => 'required|integer|min:0|max:9999',
            'currency_code' => 'required|string|min:3|max:3',
            'is_active' => ['required', Rule::in(StatusEnum::values())],
            'has_market' => ['required', Rule::in(HasMarketEnum::values())],
        ];
    }
}
